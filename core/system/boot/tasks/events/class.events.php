<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\Patterns\Observer;

    class Events extends Observer{
        /**
         * Event->_statement
         * @param \SplSubject $subject
         */
        public function update( \SplSubject $subject ) {
            $statement = $subject->getStatement();
            // Callbacks
            switch($statement) {
                case 'idle':
                    echo "idle";
                    break;

                case 'started':
                    echo "started";
                    break;

                case 'ended':
                    echo "ended";
                    break;
            }
        }
    }
}