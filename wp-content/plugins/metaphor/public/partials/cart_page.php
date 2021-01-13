<?php 
    session_start();
    get_header();
    
// print_r($user_meta);
    // $_SESSION['cart_Array'] = array();
    // print_r($_SESSION['cart_Array']);
    if(isset($_POST['add_to_cart'])){
        
        $user_id = get_current_user_id();
        if(!empty($user_id)){
            
            $post_id = get_the_ID();
            // echo $post_id;
            $product_title = get_the_title();
        
            $price = $_POST['price'];
        

            $inventory = $_POST['inventory'];

            $new_arr = array();
            $arr = array('post_id'=> $post_id, 'title'=> $product_title, 'price' => $price, 'image' => get_the_post_thumbnail_url( get_the_ID()), 'inventory' => $inventory);
            array_push($_SESSION['cart_Array'], $arr);

            $user_meta = get_user_meta( $user_id, 'add_cart' , true);
        
            $flag = 1;
            if(empty($user_meta)){
                $user_meta = array($arr);
                update_user_meta( $user_id, 'add_cart', $user_meta ); 
                echo "<script>alert('Product added successfully')</script>";
            }else{
                // array_push($new_arr[], $arr);
                if(!empty($user_meta)) {
                    foreach($user_meta as $key => $value){
                        // echo $post_id;
                        print_r( $value['post_id']);
                        if($post_id == $value['post_id']){
                            $user_meta[$key]['inventory'] += 1;
                            // print_r( $value['inventory']);
                            // update_user_meta( $user_id, 'add_cart', $user_meta ); 
                            $flag = 0;
                        }
                    
                    }
                }
                if($flag == 0){
                    update_user_meta( $user_id, 'add_cart', $user_meta ); 
                    echo "<script>alert('Product added successfully')</script>";
                }else{
                    $user_meta[] = $arr;
                    update_user_meta( $user_id, 'add_cart', $user_meta ); 
                    echo "<script>alert('Product added successfully')</script>";
                    // $flag ="";
                }
                // update_user_meta( $user_id, 'add_cart', $user_meta ); 

            }
        }else{
            $post_id = get_the_ID();
            // echo $post_id;
            $product_title = get_the_title();
            $price = $_POST['price'];
            $inventory = $_POST['inventory'];

        
            if(!isset($_SESSION['cart_Array'])){
                $_SESSION['cart_Array']=array();
            }
           
            $flag = 0;
            foreach($_SESSION['cart_Array'] as $key => $value){
                if($post_id == $value['post_id']){
                    $_SESSION['cart_Array'][$key]['inventory'] += 1;
                    $flag = 1;
                }
            
            }

            if($flag == 0){
                $arr = array('post_id'=> $post_id, 'title'=> $product_title, 'price' => $price, 'image' => get_the_post_thumbnail_url( get_the_ID()), 'inventory' => $inventory);
                array_push($_SESSION['cart_Array'], $arr);
            }
            print_r($_SESSION['cart_Array']);
           
            // array_push($_SESSION['cart_Array'], $arr);
            // session_destroy();
            
        }
    }


    
?>
    <form method="post">
        <table>
            <tr>
                <th>Title</th>
                <th>Product</th>
                <th>Inventory</th>
                <th>Price</th>
                <th>Add to cart</th>
            </tr>

            <tr>
                <td>
                    <div class="post">
                    <h2 class="title"><a href="<?php the_permalink();?>" ><?php the_title();?> </a></h2>
                
                </td>

                <td>
                    <div class="entry">
                    
                        <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();?></p>
                    
                    </div>
                </td>
                
                
                <td>
                    <input type="hidden" name = "inventory" value = "<?php echo get_post_meta(get_the_ID(), 'inventory_meta_key', true);?>">
                    <?php echo get_post_meta(get_the_ID(), 'inventory_meta_key', true);?>
                
                </td>

                <td>
                    <?php 
                    if((get_post_meta(get_the_ID(), 'price_discount_key', true)) == 0 || (get_post_meta(get_the_ID(), 'price_discount_key', true)) == " " ){ ?>
                            <input type="hidden" name = "price" value = "<?php echo get_post_meta(get_the_ID(), 'price_meta_key', true);?>"><?php

                            echo get_post_meta(get_the_ID(), 'price_meta_key', true);
                            }else{?>
                                <input type="hidden" name = "price" value = "<?php echo get_post_meta(get_the_ID(), 'price_discount_key', true);?>">
                        <?php echo get_post_meta(get_the_ID(), 'price_discount_key', true); }?>
                    <br>
                </td>
        
                <td>
                    <p>
                        <input type="submit" name = "add_to_cart" value = "Add To Cart">
                    </p>
                </td>
            </tr>
        </table>
    </form>
<?php

    get_footer();
?>
