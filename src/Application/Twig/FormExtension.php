<?php

namespace App\Application\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Application\Form\Field;
use App\Application\Form\InputField;

class FormExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'fieldBuilder', 
                [$this, 'fieldBuilder'],
                ['is_safe' => 'html'],
            ),
        ];
    }
    
    /**
     * fieldBuilder
     * 
     * Generate HTML code of a field
     *
     * @param  Field $field
     * @param  string[] $options Names of attributes you want to use 
     * in the html element (the field) : input or textarea or select ...
     * @param ?string $class class attribute for the html element of the field
     * @return string
     */
    public function fieldBuilder(Field $field, array $options = [], ?string $class): string
    {
        $html = '<label for="' . $field->getIdField() . '">' . $field->getTextLabel() . '</label>';
        $htmlAttributes = 'id="' . $field->getIdField() . ' name=' . $field->getName();
        
        $attributes = [];
        foreach ($options as $option) {
            $attribute = 'get'.ucfirst($option);
            if (is_callable([$field, $attribute]) && !empty($field->$attribute())) {
                    $attributes[$option] = $field->$attribute();
            }
        }
        if (!empty($class)) {
            $attributes['class'] = $class;
        }
        
        if($field->getTag() === 'input') {
            if ($field instanceof InputField) {
                $html .= $this->input($field, $attributes);
            }
        }
        if($field->getTag() === 'textarea') {
            $html .= $this->textarea($field->getValueField(), $attributes);
        }

        return $html;
    }
    
    /**
     * getHtmlFromArray
     * 
     * Transform an array $key => $value into HTML attributes
     *
     * @param  array $attributes
     * @return string
     */
    public function getHtmlFromArray(array $attributes): string
    {   
        return implode(
            ' ',
            array_map(
                function ($key, $value) {
                    return $key. '="' . $value .'"';// => key="value"
                }, 
                array_keys($attributes),            // $key : attributes names
                $attributes                         // $value 
            )
        );
    }
    
    /**
     * input
     * 
     * Generate an input field
     *
     * @param  InputField $field
     * @param  array $attributes
     * @return string
     */
    public function input(InputField $field, array $attributes = []): string
    {
        $valueAttr = "";
        if (!empty($field->getValueField())) {
            $valueAttr = "value = \"" . $field->getValueField() . "\">";
        }
        return '<input type="' . $field->getType() . '" ' . $this->getHtmlFromArray($attributes) . ' ' . $valueAttr;
    }
    
    /**
     * textarea
     * 
     * Generate a textarea field
     *
     * @param  ?string $value
     * @param  array $attributes
     * @return string
     */
    public function textarea(?string $value, array $attributes = []): string
    {
        return '<textarea ' . $this->getHtmlFromArray($attributes) . '>' . $value . '</textarea>';
    }
}
