<?php

namespace helpers;

use yii\db\Query;
use yii\helpers\Url;
use yii\bootstrap4\Html;

//    Este es un helper para generar una vista de arbol.
//    El siguiente es un ejemplo de configuración.
//
//    Se instancia y genera: (new Arbol)->genArbol($raiz, $config);
//
//    Los parámetros de configuración es un array con campos de la
//    db y urls. Se pueden generar con una función o directamente 
//    en la variable $config. El siguiente es un ejemplo para generar
//    un arbol con la tabla menu. Que, por cierto, es la estructura
//    para la que está pensado este helper.
//
//    private function arbolMenu()
//        {
//            $config = [
//                'tabla' => 'menu',
//                'id' => 'm_id',
//                'parent' => 'm_parent',
//                'ref' => '/admin/menu',
//                'ref_insert' => '/admin/menu/edit',
//                'ref_edit' => '/admin/menu/edit',
//                'nombre' => 'm_texto',
//                // 'order' => 'm_valor',
//                'titulo' => 'Gestor de Menús',
//                'nuevo' => 'Nuevo menu raíz',
//                // 'dropdown' => 'm_ident',
//                'id_link' => 'm_valor'
//            ];
//
//            return $config;
//        }

//    TABLE public.menu (
//    m_id integer NOT NULL,
//    m_parent integer,
//    m_ident character varying(200),
//    m_grupo character varying(45),
//    m_orden integer,
//    m_texto character varying(255),
//    m_url character varying(255),
//    m_valor integer,
//    m_curl character varying(255)
//    );

//    ALTER TABLE ONLY public.menu
//    ADD CONSTRAINT menu_pkey PRIMARY KEY (m_id);

class Arbol
{
	public function genArbol($raiz, $config = [])
	{
		$config['order'] = $config['order'] ?? $config['nombre'];
		// Se recuperan los datos de la tabla...
		$query = new Query();

		if (isset($config['donde'])) $query->where($config['donde']);

		if ($raiz != 0)
		{
			$query->andWhere(['=', $config['id'], $raiz]);
			$query->orWhere(['=', $config['parent'], $raiz]);
		}
		if (isset($config['group_by'])) $query->addGroupBy($config['group_by']);
		$query->addOrderBy($config['order']);
		$items = $query->from($config['tabla'])->all();

		// Se pinta la representación de arbol...

		$t = isset($config['titulo']) ? $config['titulo'] : FALSE;
		$n = isset($config['nuevo']) ? $config['nuevo'] : '';
		if (! empty ($config['titulo'])) {
                    $this->out = Html::tag ('h3', $t);
                }
                $this->out .= Html::a($n, [$config['ref_insert'], $config['parent'] => $raiz], 
                        ['class' => 'btn btn-success btn-sm']);
		$this->out .= "<div style='column-count:auto; column-width:20em;'>";
		$this->createTreeView($items, $raiz, $config);
		$this->out .= "</div>";
		return $this->out;
	}

	public function createTreeView($items, $raiz, $config = [], $CL = 0, $PL = -1)
	{
		foreach ($items as $item)
		{
			if ($raiz == $item[$config['parent']])
			{
                            $link = $item[$config['id_link']] ?? $item[$config['id']];
                            $id_link = Html::tag('li', Html::a($link, [$config['ref_edit'], $config['id'] => $item[$config['id']]]));
			    $id_link = "<li><a href='".Url::to($config['ref_edit']."?". $config['id']."=".$item[$config['id']]).
				"'><b>".$link.'</b> - </a>';

                            if ($CL > $PL) $this->out .= "<ul>"."\n";
                            if ($CL == $PL) $this->out .= "</li>"."\n";

                            $this->out .= $id_link . Html::a($item[$config['nombre']], [$config['ref_insert'],
                                $config['parent'] => $item[$config['id']]]);

                            if ($CL > $PL) $PL = $CL;

                            $CL++;
                            $this->createTreeView ($items, $item[$config['id']], $config, $CL, $PL);
                            $CL--;
			}
		}
		if ($CL == $PL)
		{
			$this->out .= "</li></ul>"."\n";
		}
	}
}
// fin de documento
