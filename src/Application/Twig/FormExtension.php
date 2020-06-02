<?php

namespace App\Application\Twig;

use App\Application\Form\Field;
use App\Application\Form\InputField;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'fieldBuilder',
                [$this, 'fieldBuilder'],
                ['is_safe' => ['html']],
            ),
        ];
    }

    /**
     * fieldBuilder.
     *
     * Generate HTML code of a field
     *
     * @param string[] $options Names of attributes you want to use in the html element (the field) :
     *                          input or textarea or select ...
     * @param ?string  $class   value of class attribute for the html element of the field
     */
    public function fieldBuilder(Field $field, array $options = [], ?string $class): string
    {
        // define values of attributes for html element
        $attributes['id'] = $field->getIdField();
        $attributes['name'] = $field->getName();
        foreach ($options as $option) {
            $attribute = 'get'.ucfirst($option);
            if (is_callable([$field, $attribute]) && !empty($field->{$attribute}())) {
                $attributes[$option] = $field->{$attribute}();
            }
        }
        if (!empty($class)) {
            $attributes['class'] = $class;
        }
        // write the label tag
        $html = '';
        if (!empty($field->getTextLabel())) {
            $html .= '<label for="'.$field->getIdField().'">'.$field->getTextLabel().'</label>';
        }
        // add the field tag
        if ('input' === $field->getTag()) {
            if ($field instanceof InputField) {
                $html .= $this->input($field, $attributes);
            }
        }
        if ('textarea' === $field->getTag()) {
            $html .= $this->textarea($field->getValueField(), $attributes);
        }
        // add an error message if it exists
        if ($field->getErrorMessage()) {
            $html .= $this->errorHTML($field->getErrorMessage());
        }

        return $html;
    }

    /**
     * getHtmlFromArray.
     *
     * Transform an array $key => $value into HTML attributes
     */
    public function getHtmlFromArray(array $attributes): string
    {
        return implode(
            ' ',
            array_map(
                function ($key, $value) {
                    return $key.'="'.$value.'"'; // => key="value"
                },
                array_keys($attributes),            // $key : attributes names
                $attributes                         // $value
            )
        );
    }

    /**
     * input.
     *
     * Generate an input field
     */
    public function input(InputField $field, array $attributes = []): string
    {
        $valueAttr = '';
        if (!empty($field->getValueField())) {
            $valueAttr = 'value = "'.$field->getValueField().'"';
        }

        return '<input type="'.$field->getType().'" '.$this->getHtmlFromArray($attributes).' '.$valueAttr.'/>';
    }

    /**
     * textarea.
     *
     * Generate a textarea field
     *
     * @param ?string $value
     */
    public function textarea(?string $value, array $attributes = []): string
    {
        return '<textarea '.$this->getHtmlFromArray($attributes).'>'.$value.'</textarea>';
    }

    public function errorHTML(string $errorMessage): string
    {
        return '<small class="text-danger">'.$errorMessage.'</small>';
    }
}
