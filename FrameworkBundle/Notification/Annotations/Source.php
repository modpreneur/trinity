<?php
    namespace Trinity\FrameworkBundle\Notification\Annotations;

    /**
     * Class Source
     * @author  Tomáš Jančar
     *
     * @Annotation
     */
    class Source
    {
        /** @var array  */
        protected $columns;

        /** @var bool  */
        protected $allColumnsSelected = false;



        function __construct($metadata = array())
        {
            $this->columns = (isset($metadata['columns']) && $metadata['columns'] != '') ? array_map('trim', explode(',', $metadata['columns'])) : array();

            foreach ($this->getColumns() as &$column) {
                if ($column == "*") {
                    $this->allColumnsSelected = true;
                    unset($column);
                    return;
                };
            }
        }



        /**
         * @return bool
         */
        public function hasColumns()
        {
            return !empty($this->columns);
        }



        /**
         * @return array|null
         */
        public function getColumns()
        {
            return $this->columns;
        }



        /**
         * Rename?
         * @return bool
         */
        public function isAllColumnsSelected()
        {
            return $this->allColumnsSelected;
        }



        /**
         * @param $column
         * @return bool
         */
        public function hasColumn($column){
            $cols = [];
            foreach($this->columns as $c){$cols[] = strtolower($c);}
            return in_array(strtolower($column), $cols);
        }

    }