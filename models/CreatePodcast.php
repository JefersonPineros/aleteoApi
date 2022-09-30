<?php

class CreatePodcast {
    
    private $id;

    private $name_podcast;

    private $describe_podcast;

    private $url_podcast;
    
    private $url_img;

    private $register_create;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getName() {
        return $this->name_podcast;
    }

    function setName($name_podcast) {
        $this->name_podcast = $name_podcast;
    }

    function getDescribePodcast() {
        return $this->describe_podcast;
    }

    function setDescribePodcast($describe_podcast) {
        $this->describe_podcast = $describe_podcast;
    }

    function getUrlPodcast() {
        return $this->url_podcast;
    }

    function setUrlPodcast($url_podcast) {
        $this->url_podcast = $url_podcast;
    }

    function getUrlImage() {
        return $this->url_img;
    }

    function setUrlImage($url_img) {
        $this->url_img = $url_img;
    }

    function getRegisterCreate() {
        return $this->register_create;
    }

    function setRegisterCreate($register_create) {
        $this->register_create = $register_create;
    }

}

?>