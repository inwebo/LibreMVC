<?php
namespace LibreMVC\Routing {
    interface ISegmentable {
        public function toSegments();
        public function countSegments();
    }
}