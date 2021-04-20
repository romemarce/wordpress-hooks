<?php

function mostrarMenuPerfil(){
	echo '<ul class="menu__top">';
		$usuario = getUsuarioActual();
		
		$miCuenta = home_url().'/mi-cuenta/';
		$misPedidos = home_url().'/mi-cuenta/orders/';
		$miCarrito = home_url().'/carrito/';
		$cerrarCuenta = home_url().'/wp-login.php?action=logout';
		$misFavoritos = home_url().'/favoritos/';
    
		if ($usuario !== 'Invitado'):
			echo '<li class="usuario">Hola '.$usuario.' !
				<ul class="sub-usuario">
					<li><a href="'.$miCuenta.'">Mis datos</a></li>
					<li><a href="'.$misPedidos.'">Mis pedidos</a></li>
					<li><a href="'.$cerrarCuenta.'">Cerrar sesión</a></li>
				</ul>
			</li>';
			echo '<li class="favoritos"><a href="'.$misFavoritos.'">Favoritos</a></li>';
			echo '<li class="carrito"><a href="'.$miCarrito.'">Carrito</a></li>';

		else:
			echo '<li><a href="#newsletter">Suscribite al newsletter</a></li>
			  <li class="favoritos"><a href="'.$misFavoritos.'">Favoritos</a></li>
			  <li><a href="'.$miCuenta.'" alt="">Ingreso / Registro</a></li>
			  <li><a href="'.$miCarrito.'">Carrito</a></li>';
		endif;
	echo '</ul>';
}
		

function cargarTitulo($titulo){
  echo '<div class="page_title">';
  echo '<h1>'.$titulo.'</h1>';
  echo '</div>';
}

function getUsuarioActual(){
  $usuario = 'Invitado';
  if(is_user_logged_in()):
    global $current_user;
    wp_get_current_user();

    $usuario = $current_user->user_login;
  endif;

  return $usuario;
}

function obtenerContenidoCarrito(){
  $productosEnCarrito = WC()->cart->get_cart_contents_count();
  if ($productosEnCarrito > 99) {
    $productosEnCarrito = '99+';
  }
  return $productosEnCarrito;
}

function obtenerTotalCarrito(){
  $total = WC()->cart->get_totals();
  return ($total['total'] != 0)? $total['total'] : '0.00';
}

function mostrar_categoria_del_producto(){
  global $product;

  $postid = $product->get_id();

  // categoria
  $auxCatProduct = get_the_terms($postid, 'product_cat');
  $catProduct = '';
  foreach ($auxCatProduct as $categorias) {
    foreach ($categorias as $key => $value) {
      if($key === 'name'){
        $catProduct .= $value . ', ';
      }
    }
  }
  $catProduct = substr($catProduct, 0, -2) . '.';

  echo '<div class="categoria">'.$catProduct.'</div>';
}

function agregar_boton_ver_mas(){
  global $post;
  $permalink = get_the_permalink($post->ID);

  echo '<a href="'.$permalink.'" class="btn__ver__mas">Ver más</a>';
}

function agregar_descripcion_corta_grilla(){
  global $product;
  $product_short_description = $product->get_short_description();

  echo '<div class="descripcion__corta">'.$product_short_description.'</div>';
}

function agregar_descripcion_larga_grilla(){
  global $product;
  $product_large_description = $product->get_description();

  echo '<div class="descripcion__larga">'.$product_large_description.'</div>'; 
}


function tr_sku_search_helper($wp){
    // WooCommerce Search by Product SKU
    // Clayton Kriesel [Three Remain Production]
    global $wpdb;

    //Check to see if query is requested
    if( !isset( $wp->query['s'] ) || !isset( $wp->query['post_type'] ) || $wp->query['post_type'] != 'product') return;
    $sku = $wp->query['s'];
    $ids = $wpdb->get_col( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value = %s;", $sku) );
    if ( ! $ids ) return;
    unset( $wp->query['s'] );
    unset( $wp->query_vars['s'] );
    $wp->query['post__in'] = array();
    foreach($ids as $id){
        $post = get_post($id);
        if($post->post_type == 'product_variation'){
            $wp->query['post__in'][] = $post->post_parent;
            $wp->query_vars['post__in'][] = $post->post_parent;
        } else {
            $wp->query_vars['post__in'][] = $post->ID;
        }
    }
}
add_filter( 'pre_get_posts', 'tr_sku_search_helper', 15 );

function generarListadoHijoDe($child_of){
  wp_list_categories(
    array(
      'taxonomy' => 'product_cat',
      'title_li' => '',
      'hide_empty'=> 0,
      'hierarchical' => true,
      'child_of' => $child_of
    )
  );
}
