<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/search_album.css" />


    <?php
    $name = $_GET["album"];
    $param = '{
    "query": {
        "match": {
          "album name": ' . '"' . $name . '"' . '
        }
    },
    "sort": {
        "_score": {
            "order": "desc"
        },
        "album comments": {
            "order": "desc"
        }
    }
}';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://121.199.77.180:9200/album/_search");
    $header = array(
        "content-type: application/json; charset=UTF8bm4"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $timeout = 10;
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $ret = json_decode($res, true);
    $total = $ret["hits"]["hits"];
    $len = count($total);
    ?>
    <title>iCrescendo-<?php echo $name; ?></title>
    <meta charset="utf8mb4">
    <base target="_blank">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>iCrescendo-Album</title>

    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<style>
    .search-input {
        border-radius: 50px;
        height: 50px;
    }

    .search-submit {
        background-image: url(images/search-icon.png);
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        position: absolute;
        left: 235px;
    }

    .codrops-demos {
        float: right;
        padding-top: 10px;
    }

    .demo-1 .codrops-demos {
        position: absolute;
        z-index: 2000;
        top: 30px;
        left: 30px;
    }

    .codrops-demos a {
        display: inline-block;
        margin: 10px;
        color: #333;
        font-weight: 700;
        line-height: 30px;
        border-bottom: 4px solid transparent;
    }

    .codrops-demos a:hover {
        color: #883d59;
        border-color: #883d59;
    }

    .codrops-demos a.current-demo,
    .codrops-demos a.current-demo:hover {
        color: #aaa;
        border-color: #aaa;
    }
</style>

<body>
    <div class="container">

        <nav class="codrops-demos" style="position: absolute; left: 400px; top: 5px;">
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <p style="font-size: 20px;">&nbsp;&nbsp;&nbsp;Please choose one type to search</p>
            <a target="_self" style="font-size: 30px; text-decoration:underline;" href="../ranking_of_singers/index.html">singers</a>
            <a target="_self" style="font-size: 30px; text-decoration:underline;" href="../ranking_of_albums/index.html">albums</a>
            <a target="_self" style="font-size: 30px; text-decoration:underline;" href="../ranking_of_songs/index.html">songs</a>
            <form target="_self" style="position: absolute; left: 500px; top: 75px; font-size: 20px;" method="GET" action="search_album.php">
                <input style="font-size: 20px;" type="text" class="search-input" placeholder="          Type to search" name="album" />
                <input type="submit" class="search-submit" value=" ">
            </form>

        </nav><br><br><br><br><br><br><br>

        <!-- <div class="navbar navbar-expand-sm bg-dark navbar-dark">
                <a href="#" class="navbar-brand">
                    <img src="http://file03.16sucai.com/2016/03/2016yisxqhd5vv4.jpg" alt="Logo" width="40px">
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="../ranking_of_singers/index.html" class="nav-link" target="_self">Singers</a>
                    </li>
                    <li class="nav-item">
                        <a href="../ranking_of_albums/index.html" class="nav-link" target="_self">Albums</a>
                    </li>
                    <li class="nav-item">
                        <a href="../ranking_of_songs/index.html" class="nav-link" target="_self">Songs</a>
                    </li>
                </ul>
            </div>
            <div class="navbar navbar-expand-sm bg-dark navbar-dark">
                <form action="search_album.php" class="form-inline" method="GET" target="_self">
                    <input type="text" class="form-control" placeholder="Search" name="album">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div> -->
        <div class="result" style='font-size:18px;'>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You searched <?php echo  '"' . $name . '"';  ?> ,
            and you get <?php echo "<em>" . $len . "</em>" . " results."; ?>
        </div>
        <div class="row" height=200px>
            <?php

            for ($i = 0; $i < $len; $i++) {
                $id = $total[$i]["_id"];
                echo "<br>";
                $source = $total[$i]["_source"];
                $cover = $source["cover"];
                $album_name = $source["album name"];
                $album_url = $source["album url"];
                $issue_date = $source["issue date"];

                echo "<div class='col' style='padding-right: 100px;padding-left: 50px;height:300px;width:300px;'>";
                echo "<a style='color:#ef91b8;font-size: 1.4rem;font-weight: 600;' target='_self' href = '../ranking_of_albums/php/album.php?album=" . $album_name . "'>";
                echo $album_name . "</a><br>";
                echo "<p style='color:#f39f9f;font-size: 1.1rem;'>Issue date:  $issue_date  <br></font>";
                echo "<img src='" . $cover . "' alt='image'><br>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>

</html>