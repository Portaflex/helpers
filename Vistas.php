<?php

namespace helpers;

use yii\db\Query;
use yii\helpers\Url;

class Vistas
{

    // *************************************************************************
    // ** Funciones para Vistas **
    // *************************************************************************
    private $out;

    public function genera_menu ($data, $raiz, $config)
    {
        $this->out .= '<ul class="' . $config['menu_tipo'] . '">' . "\n";
        $this->createTreeViewMenu($data, $raiz, $config);
        $this->out .= "</ul>";
        return $this->out;
    }

    public function genera_arbol ($raiz, $config = [])
    {
        // Se recuperan los datos de la tabla...
        $query = new Query();
        $query->from($config['tabla']);

        if (isset($config['donde']))
            $query->where($config['donde']);

        if ($raiz != 0)
        {
            $query->where($config['id'], $raiz);
            $query->orWhere($config['parent'], $raiz);
        }
        if (isset($config['group_by']))
            $this->CI->db->group_by($config['group_by']);
        $query->orderBy($config['nombre']);
        $items = $query->all();

        // Se pinta la representación de arbol...

        $t = isset($config['titulo']) ? $config['titulo'] : FALSE;
        $n = isset($config['nuevo']) ? $config['nuevo'] : '';
        if (! empty($config['titulo']))
            $this->out = '<h2><a href=' . Url::toRoute($config['ref']) . '>' . $t . '</a></h2>
				<b><a href=' .
                     Url::toRoute($config['ref_insert'] . '/0') . '>' . $n .
                     '</a></b>';
        $this->out .= '<div class="columns3">';
        $this->createTreeView($items, $raiz, $config);
        $this->out .= "</div>";
        return $this->out;
    }

    public function createTreeView ($items, $raiz, $config = [], $CL = 0, $PL = -1)
    {
        foreach ($items as $item)
        {
            if ($raiz == $item[$config['parent']])
            {
                $id_link = ! empty($config['id_link']) ? '<li><a href=' .
                         Url::toRoute(
                                $config['ref_edit'] . "/" . $item[$config['id']]) .
                         '><b>' . $item[$config['id']] . '</b> - </a>' : '<li>';

                if ($CL > $PL)
                    $this->out .= "<ul>" . "\n";
                if ($CL == $PL)
                    $this->out .= "</li>" . "\n";

                $this->out .= $id_link . '<a href=' .
                         Url::toRoute($config['ref_insert']) . "/" .
                         $item[$config['id']] . '>' . $item[$config['nombre']] .
                         '</a>';

                if ($CL > $PL)
                    $PL = $CL;

                $CL ++;
                $this->createTreeView($items, $item[$config['id']], $config,
                        $CL, $PL);
                $CL --;
            }
        }
        if ($CL == $PL)
        {
            $this->out .= "</li></ul>" . "\n";
        }
    }

    public function createTreeViewMenu ($menus, $raiz, $config = [], $CL = 0, $PL = -1)
    {
        $list_item = isset($config['list']) && $config['list'] == 'si' ? " class='list-group-item'" : FALSE;

        foreach ($menus as $item)
        {
            if (isset($config['dropdown']) &&
                     $item[$config['dropdown']] == 'submenu')
            {
                $li = "\n" . '<li class="dropdown">' . "\n" . '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false">' .
                $item[$config['nombre']] . "\n" .
                 '<span class="caret"></span></a>' . "\n" .
                 '<ul class="dropdown-menu">' . "\n";
                $nombre = "<b>" . $item[$config['nombre']] . "</b>";
            }
            else
            {
                $li = "</li>";
                $nombre = $item[$config['nombre']];
            }
        
            if (is_array($config['url']))
            {
                $href = Url::toRoute($config['url'][0]) . "/" . $item[$config['url'][1]];
            }
            else
            {
                $href = Url::toRoute($item[$config['url']]);
            }
        
            if ($raiz == $item[$config['parent']])
            {
                if ($CL > $PL)
                    $this->out .= $li . "\n";
                if ($CL == $PL)
                    $this->out .= "$li" . "\n";
        
                $this->out .= "<li$list_item><a href=$href>$nombre</a>";
        
                if ($CL > $PL)
                    $PL = $CL;
        
                $CL ++;
                $this->createTreeViewMenu($menus, $item[$config['id']], $config, $CL,
                        $PL);
                $CL --;
            }
      }
      
      if ($CL == $PL)$this->out .= "</li></ul>" . "\n";
      
    }
}
