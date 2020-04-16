<?php
ini_set('display_errors', 1);

// StatsAPI PHP script v1 (05-02-2020).
// by Snx.

// Database Configuration!
$database_adress = "adress";
$database_name = "database_name";
$database_user = "user";
$database_password = "password";

// Optional configuration
$theme = 'United'; // Themes: Cerulean, Cosmo, Cyborg, Darkly, Flatly, Journal, Lumen, Paper, Readable, Sandstone, Simplex, Slate, Spacelab, Superhero, United, Yeti
$how_many = 10;
$title = "Top $how_many Players";
$page_title = $title;
$show_uuid = false;
$padding_top = "100px";

$kills_format = "{kills}";
$deaths_format = "{deaths}";

// Head size in pixels.
$head_size = 30;

// END OF CONFIGURATION
$con = mysqli_connect($database_adress, $database_user, $database_password, $database_name);
if (mysqli_connect_errno()) {
    die("<h3 class='text-center'>Failed to connect to MySQL: " . mysqli_connect_error() . "</h3>");
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta content="Snx" name="author">
    <title><?php echo $title; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/<?php echo strtolower($theme) ?>/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: <?php echo $padding_top ?>;
        }
    </style>
</head>
<body>
<center>
<img src="http://ni3458006-1.web15.nitrado.hosting/Logo.png" >
</center>
<div class="container">
    <h2 class="text-center"><?php echo $page_title; ?></h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Head</th>
            <th>Nickname</th>
            <?php if ($show_uuid) { ?>
                <th>UUID</th>
            <?php } ?>
            <th>Kills</th>
			<th>Deaths</th>
        </tr>
        </thead>
        <tbody>
		<br><br>
        <?php
        $num = 0;

        $result = mysqli_query($con, "SELECT * FROM `StatsAPI` ORDER BY `Kills` DESC LIMIT $how_many");

        if (!$result) {
            die("ERROR: Server not returned any data. " . mysqli_error($con));
        }

        while ($row = mysqli_fetch_array($result)) {
            $num++;
            $uuid = $row['UUID'];
            $nick = $row['Name'];
            $kills = $row['Kills'];
			$deaths = $row['Deaths'];
            $img = sprintf('<img src="https://minotar.net/helm/%s/%d.png">', $nick, $head_size);

            echo "<tr><td>$num</td><td>$img</td><td>$nick</td>";

            if ($show_uuid)
                echo "<td>$uuid</td>";

            echo "<td>" . str_replace("{kills}", $kills, $kills_format) . "</td>";
			      echo "<td>" . str_replace("{deaths}", $deaths, $deaths_format) . "</td></tr>";
        }

        mysqli_close($con);
        ?>
        </tbody>
    </table>
<br><br><br><br>
    <div class="footer">
        &copy; <a href="https://www.spigotmc.org/members/snx.838891/" target="blank">Snx</a> for <a href="https://www.spigotmc.org/resources/statsapi.74908/" target="blank">StatsAPI</a> Spigot plugin.
    </div>
</div>

</body>
</html>
