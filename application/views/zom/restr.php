<html>
    <head>
        <title>Zomato API</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

        <div class="container" >
            <!-- <h3 style="color:white; text-align:center;">Restaurant Review System (Moengage Assignment)</h3> -->
        
            <div class="row">
            <form action="<?=CTRL?>Zom/search"  method="post">
                <div class="form-group" style="font-weight:bold;">
                <div class="col-lg-3">
                    <select class="form-control" name="cuisine">
                        <option value="<?php echo $_SESSION['cuisine']; ?>" selected>
                        <?php
                            if($_SESSION['cuisine']==0)
                                echo "Select Cuisine";
                            else{
                                foreach($cuisines as $c){
                                    if($c['cuisine']['cuisine_id']==$_SESSION['cuisine']){
                                        echo $c['cuisine']['cuisine_name'];
                                        break;
                                    }
                                }
                            }
                        ?>
                        </option>
                        <option value="0">All</option>
                        <?php
                            foreach($cuisines as $c){
                        ?>
                        <option value="<?php echo $c['cuisine']['cuisine_id']; ?>"><?php echo $c['cuisine']['cuisine_name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control" name="type">
                    <option value="<?php echo $_SESSION['type']; ?>" selected>
                        <?php
                            if($_SESSION['type']==0)
                                echo "Select Restaurant type";
                            else{
                                foreach($type as $c){
                                    if($c['establishment']['id']==$_SESSION['type']){
                                        echo $c['establishment']['name'];
                                        break;
                                    }
                                }
                            }
                        ?>
                        </option>
                        <option value="0">All</option>
                        <?php
                            foreach($type as $c){
                        ?>
                        <option value="<?php echo $c['establishment']['id']; ?>"><?php echo $c['establishment']['name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control" name="category">
                    <option value="<?php echo $_SESSION['category']; ?>" selected>
                        <?php
                            if($_SESSION['category']==0)
                                echo "Select Restaurant category";
                            else{
                                foreach($categories as $c){
                                    if($c['categories']['id']==$_SESSION['category']){
                                        echo $c['categories']['name'];
                                        break;
                                    }
                                }
                            }
                        ?>
                        </option>     
                        <option value="0">All</option>
                                           <?php
                            foreach($categories as $c){
                        ?>
                        <option value="<?php echo $c['categories']['id']; ?>"><?php echo $c['categories']['name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                <button type="submit" class="btn btn-success btn-block" style="font-weight:bold;">Search</button>
                </div>
                </div>
            </form>
            </div>
            <br>
            <br>

                <div class="row">

                    <?php
                        foreach($restaurant as $r){
                            //echo $r['restaurant']['name'];
                            //echo "<br>";
                            ?>  <a href="<?=CTRL?>Zom/restaurant/<?php echo $r['restaurant']['id']; ?>">
                                <div class="col-lg-6" style="margin-top:20px;">
                                    <div class="card" style="width:auto; margin: 0 auto; border-style:groove; border-color:white; border-spacing:20px; ">
                                        <div class="row" style="border-spacing:0; padding:10px;">
                                            <div class="col-lg-6" >
                                            <img class="card-img-top" style="width:60%;" src="<?php echo $r['restaurant']['thumb']; ?>" alt="Image not found">
                                            </div>
                                            <div class="col-lg-6">
                                            <button type="button" style="align:left;" class="btn btn-success btn-block"><?php echo $r['restaurant']['user_rating']['aggregate_rating']; echo " ("; echo $r['restaurant']['user_rating']['votes']; echo " votes)"?></button>
                                            <br>    
                                            <a href="<?php echo $r['restaurant']['url']; ?>" target="_blank"><button type="button" style="align:left;" class="btn btn-danger btn-block">See on Zomato</button></a>
                                            <br>
                                            <?php
                                            $address=$r['restaurant']['location']['address'];
                                            if(strlen($address) > 65){
                                               $address = substr($address ,0, 62) . "...";
                                            }
                                            ?>
                                            <p class="card-text"><?php echo $address; ?></p>

                                        </div>
                                        </div>
                                            <div class="card-body" style="padding:10px;">
                                                <h4 class="card-title"><?php echo $r['restaurant']['name']; ?></h4>
                                                <p class="card-text">Cusines : <?php echo $r['restaurant']['cuisines']; ?></p>
                                                <p class="card-text">₹<?php echo $r['restaurant']['average_cost_for_two']; ?> for two</p>
                                            </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    ?>
                    </div>

            
        </div>
    </body>
</html>
