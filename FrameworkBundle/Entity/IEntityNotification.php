<?php

    namespace Trinity\FrameworkBundle\Entity;

    use Necktie\AppBundle\Entity\Client;



    interface IEntityNotification
    {


        /** @return int */
        public function getId();



        /** @return Client|Client[] */
        public function getClients();


    }