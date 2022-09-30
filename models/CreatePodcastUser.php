<?php

class PodcastUser {

    private $id;

    private $url_podcast;

    private $name_user;

    private $check_terminos;

    private $register_create;


    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function geUrlPodcast() {
        return $this->url_podcast;
    }

    function setUrlPodcast($url_podcast) {
        $this->url_podcast = $url_podcast;
    }

    function geNameUser() {
        return $this->name_user;
    }

    function setNameUser($name_user) {
        $this->name_user = $name_user;
    }

    function getCheckTerminos() {
        return $this->check_terminos;
    }

    function setCheckTerminos($check_terminos) {
        $this->check_terminos = $check_terminos;
    }

    function getRegisterCreate() {
        return $this->register_create;
    }

    function setRegisterCreate($register_create) {
        $this->register_create = $register_create;
    }
}
?>