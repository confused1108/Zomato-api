<html>
    <head>
        <title>Zomato API</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            
        </style>
    </head>
    <body style="background-color:#2c28a8; color:white;">

    <nav class="navbar navbar-light" style="background-color:#ffffe6; color:white;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><button class="btn btn-light" style="font-weight:bold; background-color:#2c28a8; color:white;">&ensp;&ensp;&ensp;Restaurant Review System&ensp;&ensp;&ensp;</button>&ensp;&ensp;&ensp;</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="<?=CTRL?>Zom/restr"><button class="btn btn-light" style="font-weight:bold; background-color:#2c28a8; color:white;">&ensp;&ensp;&ensp;Search&ensp;&ensp;&ensp;</button></a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right" >
                <li><a href="#"><button class="btn btn-light" style="font-weight:bold; background-color:#2c28a8; color:white;">&ensp;&ensp;&ensp;<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name']; ?>&ensp;&ensp;&ensp;</button></a></li>
                <li><a href="<?=CTRL?>Zom/logout"><button class="btn btn-light" style="font-weight:bold; background-color:#2c28a8; color:white;">&ensp;&ensp;&ensp;<span class="glyphicon glyphicon-log-in"></span> Logout&ensp;&ensp;&ensp;</button></a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin:0">
        <div class="row">
            <div class="col-lg-6">
                <img style="width:100%;" src="<?php echo $restaurant['featured_image']; ?>" alt="Card image">
            </div>
            <div class="col-lg-6">
                <h1><?php echo $restaurant['name']; ?></h1>
                <h4 style="color: #bfbfbf;font-size: 15px;">&ensp;<?php echo $restaurant['cuisines']; ?></h4>
                <h6 style="color: #bfbfbf;font-size: 15px;">&ensp;<?php echo $restaurant['location']['locality_verbose']; ?></h6>
                <h6 style="color: #bfbfbf;font-size: 15px;">&ensp;<?php echo $restaurant['timings']; ?></h6>
                <h6 style="color: #bfbfbf;font-size: 15px;">&ensp;₹<?php echo $restaurant['average_cost_for_two']; ?> for two</h6>

                <div class="row">
                
                <div class="col-lg-6">
                <button type="button" style="margin-top:10px;" class="btn btn-success"><?php echo $restaurant['user_rating']['aggregate_rating']; echo " ("; echo $restaurant['user_rating']['votes']; echo " votes)"?></button>
                </div>
                
                <div class="col-lg-6">  
                <a href="<?php echo $restaurant['url']; ?>" target="_blank" ><button style="margin-top:10px;" type="button" style="align:left;" class="btn btn-danger">See on Zomato</button></a>
                </div>
                
                <div class="col-lg-6">
                <a href="<?php echo $restaurant['menu_url']; ?>" target="_blank"><button style="margin-top:10px;" type="button" style="align:left;" class="btn btn-info">Check out Menu</button></a>
                </div>
                
                <div class="col-lg-6">
                <a href="<?php echo $restaurant['photos_url']; ?>" target="_blank"><button style="margin-top:10px;" type="button" style="align:left;" class="btn btn-warning">See more photos</button></a>
                </div>
                </div>
                <br>
                <div class=row>
                        <div class="col-lg-6">
                            <h5>Online Delivery : <?php if($restaurant['has_online_delivery']) echo "<span class='glyphicon glyphicon-ok-circle' style='color:green'></span>"; else echo "<span class='glyphicon glyphicon-remove-circle' style='color:red'></span>"; ?></h5>
                        </div>
                        <div class="col-lg-6">
                            <h5>Delivering now : <?php if($restaurant['is_delivering_now']) echo "<span class='glyphicon glyphicon-ok-circle' style='color:green'></span>"; else echo "<span class='glyphicon glyphicon-remove-circle' style='color:red'></span>"; ?></h5>
                        </div>
                        <div class="col-lg-6">
                            <h5>Table Booking : <?php if($restaurant['has_table_booking']) echo "<span class='glyphicon glyphicon-ok-circle' style='color:green'></span>"; else echo "<span class='glyphicon glyphicon-remove-circle' style='color:red'></span>"; ?></h5>
                        </div>
                        
                </div>
            </div>
        </div>
        <br>
        <h3 style="text-align:center; color:white;">Highlights</h4>
        <hr style="color:white;">
        <div class="row">
            
                    <?php
                        foreach($restaurant['highlights'] as $r){
                        //if($restaurant['highlights'][$i]){
                            ?>
                                <div class="col-lg-3">
                                    <h5><span class='glyphicon glyphicon-ok-circle' style='color:green'></span> <?php echo $r; ?></h5>
                                </div>
                            <?php
                        }
                    
                    ?>
                
        </div>
        <hr>
        <h3>Post a Review...</h3>
        <div class="row">
            <div class="col-lg-6">
            <form action="<?=CTRL?>Zom/post_review/<?php echo $this->uri->segment('3'); ?>"  method="post">
                <label class="radio-inline">
                    <h4 style="font-weight:bold;color:#ff66a3">Rate it : </h4>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rating" value="1">1
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rating" value="2">2
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rating" value="3">3
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rating" value="4">4
                </label>
                <label class="radio-inline">
                    <input type="radio" name="rating" value="5" checked>5
                </label>
                <div class="form-group">
                    <textarea style="border-left:solid 5px #ff66a3;" class="form-control" rows="3" id="comment" name="review" required placeholder="write your review about restaurant..."></textarea>
                </div>
                <button type="submit" class="btn btn-light" style="background-color:#ff66a3">Submit</button> 
            </form>
            
            
            </div>

            <div class="class-lg-6">
            <?php
                foreach($reviewdata as $r){
                    ?>
                        
                            
                                <div class="col-lg-1"></div>
                            
                                <div class="col-lg-5">
                                <span class="glyphicon glyphicon-user" style="padding-top: 5px; color:#ff66a3; font-size:25px; top: 6px;"></span>
                                &ensp;
                                <p style="border-radius: 25px; display:inline; color:black; font-weight:15px; background-color: #ccffcc; padding: 5px 10px 5px 10px;"><?php echo $r['rating']; ?></p>
                                &ensp;
                                <p style="border-radius: 25px; display:inline; color:black; font-weight:15px; background-color: #ffcce0; padding: 5px 10px 5px 10px;"><?php echo $r['review']; ?></p>
                                </div>
                          

                        
                    <?php
                }
            ?>
            </div>
        </div>
    </div>
    </body>
</html>
