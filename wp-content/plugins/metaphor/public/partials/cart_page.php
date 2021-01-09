<?php 
    get_header();
    
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

    if(isset($_POST['add_to_cart'])){
        $product_title = get_the_title();
        // echo $product_title."</br>";

        // $image =  get_the_post_thumbnail_url( get_the_ID(), the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) ));
        // echo $image."</br>";
        

        $price = $_POST['price'];
        // echo $price."</br>";

        $inventory = $_POST['inventory'];
        // echo $inventory."</br>";

        

        $arr=array('title'=> $product_title, 'price' => $price, 'image' => get_the_post_thumbnail_url( get_the_ID()), 'inventory' => $inventory);

        $_SESSION['cart_Array'] = $arr;
       
        print_r($arr);
        
        echo "</br>";

        
        $user_id = get_current_user_id();
        echo $user_id;
        echo "</br>";

        // $userdata = get_userdata( $user_id );
        // print_r($userdata);

        // foreach ($userdata as $user) {  
        //     $meta_key = $user->meta_key;         
        //   }

        //   echo $meta_key;
        $user_meta = get_user_meta( $user_id, 'add_cart' , false);
       print_r($user_meta);
       echo "</br>";
    

        if(!empty($user_id)){

            foreach ($_SESSION['cart_Array'] as $key => $val){
                print_r($val);
                if($product_title == $val ){
                    $inventory = $inventory++;
                    echo $inventory;

                    update_user_meta( $user_id, 'add_cart', $arr );
                }
            
            }
            

        }else{
            $_SESSION['cart_Array'] = $arr;
            // print_r($_SESSION['cart_Array']);
            echo "</br>";
          
        }


        
        // die("add");
        // echo get_post_meta(get_the_ID(), 'price_discount_key', true);
    }

    get_footer();
?>