<?php
class AM_Movie {

    protected $id_post;
    protected $rate;
    protected $date;

    public function __construct($idPost, $rateDate, $userRate = -1) {
        $this->id_post = $idPost;
        $this->rate = $userRate;
        $this->date = $rateDate;
    }

    function getPostId() {
        return $this->id_post;
    }

    function getRate() {
        return $this->rate;
    }

    function getDate() {
        return $this->date;
    }
}
