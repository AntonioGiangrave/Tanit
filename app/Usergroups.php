<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Object_;

class Usergroups extends Model
{

    protected $tree = array();

    public function users()
    {
        return $this->belongToMany('\App\User',  'user_group' , 'group_id', 'user_id' );
    }

    public function getTree()
    {
        $root = Usergroups::where('parent', 0)->get();
        foreach ($root as $group)
        {
            $this->tree[$group->id ] = "├".$group->name;
            $this->getSubTree($group->id, 1);
        }
        return $this->tree;
    }

    public function getSubTree($group, $lvl)
    {
        $subgroups = Usergroups::where('parent', $group)->get();
        foreach ($subgroups as $subgroup)
        {
            $this->tree[$subgroup->id ] = "├".str_repeat("─",$lvl)." ".$subgroup->name;
            $this->getSubTree($subgroup->id, $lvl+1);
        }
    }

}
