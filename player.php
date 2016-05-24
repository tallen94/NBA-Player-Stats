<?php
    class Player {

        function Player($data) {
            $this->stats = $data[0];
        }

        function getStats() {
            return $this->stats;
        }
    }
?>
