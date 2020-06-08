<?php

namespace App;

use \Corcel\Model\Taxonomy as CorcelTaxonomy;

class Taxonomy extends CorcelTaxonomy {

    protected $connection = 'wordpress';

    protected $hidden = ['term_id', 'description', 'parent', 'taxonomy'];
}
