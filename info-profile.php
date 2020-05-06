<html>
<head>
    <title>Info</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  
</head>
<body>
    <?php
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        if(strstr($url, "https://www.facebook.com/"))
        {
            $id = (explode('/', $url))[3];
            if (!file_exists("./TMHDetector-master/data/{$id}/outfile.txt"))
                exec("cd TMHDetector-master && py Client.py {$id} --output ./data/{$id}/outfile.txt");
            do {}
            while (!file_exists("./TMHDetector-master/data/{$id}/outfile.txt"));

            $info = "./TMHDetector-master/data/{$id}/Avatar.txt";
            $lines = file($info);
            $name = $lines[2];
            $ava = $lines[6];
            if (file_exists("./TMHDetector-master/data/{$id}/outfile.txt")) 
            {
                $f = file("./TMHDetector-master/data/{$id}/outfile.txt");
                $status = strtoupper($f[0]);
            }
        }
    ?> 

    <?php 
        $value ="";
        if(array_key_exists('agree', $_POST)) { 
            $value = "agree";
            $file = "./TMHDetector-master/comment.txt";
            writecomment($value, $id, $file);
        } 
        else if(array_key_exists('disagree', $_POST)) { 
            $value = "disagree";
            $file = "./TMHDetector-master/comment.txt";
            writecomment($value, $id, $file);
        } 
        else if(array_key_exists('other', $_POST)) 
        {
            $value = $_POST['problem'];
            $file = "./TMHDetector-master/problem.txt";
            writecomment($value, $id, $file);
        }

        function writecomment($value, $id, $file) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $str = date('d/m/Y-H:i:s') . "\t". $id . "\t" . $value . "\n";  

            $fp = fopen($file, 'a');
            fwrite($fp, $str);
            fclose($fp);
            header('Location: ./thanks.php');
        }
    ?>
    <div class="container">
        <div class="info">
            <div class="avatar">
                <img src="<?php echo $ava;?>" alt="avatar">
            </div>
            <div class="name">
            <div><?php echo $name?></div>
            <div class="status"> <?php echo "This is {$status} account";?></div>
            </div>
        </div>
        <div class="comment">
            <div class="comment-title">Please let me know your thoughts on the last result</div>
            <form class="comment-btt" method="POST">
                <button class="btt" name="agree" value="agree">Agree</button>
                <button class="btt" name="disagree" value="disagree">Disagree</button>
            </form>
            <form class="comment-problem" method="POST">
                <div class="comment-problem-title">Or any problem:  </div>
                <input class="comment-problem-lable" type="text" autocomplete="off" placeholder="Problem description" name="problem">
                <button class="comment-problem-btt" name="other" value="other">Submit</button>
            </form>
        </div>
    </div>

</body>
</html>