<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>EAI-TUGAS1</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" style="font-family: 'Lucida Handwriting', cursive; font-size: 24px;" href="index.html">Goal Tracker</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="competition.php"><b>Competitions</b></a></li>
                        <li class="nav-item"><a class="nav-link" href="standings.php">Standings</a></li>
                        <li class="nav-item"><a class="nav-link" href="top-score.php">Top Score </a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="page-section" id="">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Competitions</h2>
                <h3 class="section-subheading text-muted">Select a country and click submit to find out the results.</h3>

                <form method="post" action="">
                    <select name="country" id="country" class="form-select countries fluid col-12" aria-label="Default select example">
                        <option selected >Select Country</option>
                        <?php
                        
                        $APIkey = '824707baba6de98a8efd14aac79c3b1c922fa624bb88f590b4bf4cb0220a0a7c';
                        $url_countries = "https://apiv3.apifootball.com/?action=get_countries&APIkey=$APIkey";

                        $curl_countries = curl_init();
                        curl_setopt($curl_countries, CURLOPT_URL, $url_countries);
                        curl_setopt($curl_countries, CURLOPT_RETURNTRANSFER, true);
                        $countriesData = curl_exec($curl_countries);
                        curl_close($curl_countries);

                        $countries = json_decode($countriesData, true);
                        foreach ($countries as $country) {
                            $selected = isset($_POST['country']) && $_POST['country'] == $country['country_id'] ? 'selected' : '';
                            echo '<option value="' . $country['country_id'] . '" ' . $selected . '>' . $country['country_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <input class="btn btn-primary" type="submit" name="submit" value="Submit" style="margin-top: 10px; margin-bottom: 20px; margin-right: 76rem;">
                </form>
            </div>
                
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>League Name</th>
                                    <th>League Season</th>
                                    <th>League Logo</th>
                                    <th>Country Logo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['submit']) && isset($_POST['country'])) {
                                    $countryId = $_POST['country'];
                                    $url_leagues = "https://apiv3.apifootball.com/?action=get_leagues&country_id=$countryId&APIkey=$APIkey";

                                    $curl_leagues = curl_init();
                                    curl_setopt($curl_leagues, CURLOPT_URL, $url_leagues);
                                    curl_setopt($curl_leagues, CURLOPT_RETURNTRANSFER, true);
                                    $leaguesData = curl_exec($curl_leagues);
                                    curl_close($curl_leagues);

                                    $leagues = json_decode($leaguesData, true);

                                    foreach ($leagues as $league) {
                                        echo '<tr>';
                                        
                                        echo '<td>' . $league['league_name'] . '</td>';
                                        echo '<td>' . $league['league_season'] . '</td>';
                                        
                                        if (!empty($league['league_logo'])) {
                                            echo '<td><img src="' . $league['league_logo'] . '" width="50" height="50" style="border-radius: 50%; object-fit: cover"></td>';
                                        } else {
                                            echo '<td><img src="assets/img/coming-soon.jpg" width="50" height="50" style="border-radius: 50%; object-fit: cover"></td>';
                                        }

                                        if (!empty($league['country_logo'])) {
                                            echo '<td><img src="' . $league['country_logo'] . '" width="50" height="50"></td>';
                                        } else {
                                            echo '<td><img src="assets/img/coming-soon.jpg" width="50" height="50"></td>';
                                        }
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>          
                </div>
            </div>
        </div>
    </section>

        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
