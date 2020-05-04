<?php

namespace App\Entity;

use App\Application\Entity;

class Post extends Entity
{
    /**
     * @var string
     */
    private $tile;
    /**
     * @var string
     */
    private $slug;
    /**
     * @var string
     */
    private $content;    
    /**
     * @var string
     */
    private $abstract;    
    /**
     * @var \Datetime
     */
    private $dateCreation;
    /**
     * @var \Datetime
     */
    private $dateUpdate;    
    /**
     * @var int
     */
    private $idUser;  
 
    /**
    * Méthode permettant de savoir si le post est valide.
    * @return bool
    */
    public function isValid()
    {
        return !(      empty($this->title) 
                || empty($this->slug) 
                || empty($this->content)
                || empty($this->abstract)
                || empty($this->dateCreation)
                || empty($this->idUser)
           );
    }
  
    // SETTERS //
  
    public function setTitle(string $title) : void 
    {
        $this->title = $auteur;
    }

    public function setSlug(string $slug)  : void
    {
        $this->slug = $slug;
    }
    
    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

    public function setAbstract(string $abstract) : void
    {
        $this->abstract = $abstract;
    }
        
    public function setDateCreation(\DateTime $dateCreation) : void
    {
        $this->dateCreation = $dateCreation;
    }
    
    public function setDateUpdate(\DateTime $dateUpdate) : void
    {
        $this->dateUpdate = $dateUpdate;
    }

    public function setIdUser(int $idUser) : void
    {
        $this->idUser = $idUser;
    }

    
    // GETTERS //
    
    public function getTitle() : string
    {
        return $this->title;
    }
    
    public function getSlug() : string
    {
        return $this->slug;
    } 
    
    public function getContent() : string
    {
        return $this->content;
    }

    public function getAbstract() : string
    {
        return $this->abstract;
    }
        
    /**
     * @return DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
        
    /**
     * @return DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    public function getIdUser() : int
    {
        return $this->idUser;
    }
}
