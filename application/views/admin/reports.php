<script src="/fe/js/Chart.bundle.min.js"></script>

<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					Account Growth
				</header>
				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="chart_time_all" height="100px"></canvas>
                            <script>
                                var chart_time_all = document.getElementById("chart_time_all");
                                var myChart = new Chart(chart_time_all, {
                                    type: 'line',
                                    data: {
                                        labels: [
                                            <?php
                                                foreach( $l_axDays as $l_sDate => $l_nCount ) {
                                            ?>
                                                    "<?php echo $l_sDate ?>",
                                            <?php
                                                }
                                            ?>
                                        ],
                                        datasets: [{
                                            label: 'Accounts Over Time',
                                            data: [
                                                <?php
                                                    foreach( $l_axDays as $l_sDate => $l_nCount ) {
                                                ?>
                                                            <?php echo $l_nCount ?>,
                                                <?php
                                                    }
                                                ?>
                                            ],
                                            backgroundColor: '#cce5ff',
                                            borderColor: '#b8daff',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    min: 0
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="chart_free" height="100px"></canvas>
                            <script>
                                var chart_free = document.getElementById("chart_free");
                                var myChart = new Chart(chart_free, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            <?php
                                                foreach( $l_axAll as $l_sDate => $l_nCount ) {
                                            ?>
                                                    "<?php echo $l_sDate ?>",
                                            <?php
                                                }
                                            ?>
                                        ],
                                        datasets: [{
                                            label: 'New Accounts',
                                            data: [
                                                <?php
                                                    foreach( $l_axAll as $l_sDate => $l_nCount ) {
                                                ?>
                                                            <?php echo $l_nCount ?>,
                                                <?php
                                                    }
                                                ?>
                                            ],
                                            backgroundColor: '#dff0d8',
                                            borderColor: '#3c763d',
                                            borderWidth: 1
                                        }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    min: 0
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					Daily Active Accounts
				</header>
				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="chart_daily_active" height="100px"></canvas>
                            <script>
                                var chart_daily_active = document.getElementById("chart_daily_active");
                                var myChart = new Chart(chart_daily_active, {
                                    type: 'line',
                                    data: {
                                        labels: [
                                            <?php
                                                foreach( $l_axDailyActive as $l_xDailyActive ) {
                                            ?>
                                                    "<?php echo date( 'D m/d', strtotime( $l_xDailyActive['ForDate'] ) ) ?>",
                                            <?php
                                                }
                                            ?>
                                        ],
                                        datasets: [{
                                            label: 'Active Accounts',
                                            data: [
                                                <?php
                                                    $l_anDayOfWeek = array();
                                                    foreach( $l_axDailyActive as $l_xDailyActive ) {
                                                        $l_anDayOfWeek[ date( 'l', strtotime( $l_xDailyActive['ForDate'] ) ) ] = $l_anDayOfWeek[ date( 'l', strtotime( $l_xDailyActive['ForDate'] ) ) ] + $l_xDailyActive['ActiveUsers'];
                                                ?>
                                                            <?php echo $l_xDailyActive['ActiveUsers'] ?>,
                                                <?php
                                                    }
                                                ?>
                                            ],
                                            backgroundColor: '#cce5ff',
                                            borderColor: '#b8daff',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    min: 0
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="chart_day_of_week" height="200px"></canvas>
                            <script>
                                var chart_day_of_week = document.getElementById("chart_day_of_week");
                                var myChart = new Chart(chart_day_of_week, {
                                    "type":"horizontalBar",
                                    "data":{
                                        "labels":[
                                            "Monday",
                                            "Tuesday",
                                            "Wednesday",
                                            "Thursday",
                                            "Friday",
                                            "Saturday",
                                            "Sunday",
                                        ],
                                        "datasets":[{
                                            "label":"Users",
                                            "data":[
                                                <?php echo $l_anDayOfWeek['Monday'] ?>,
                                                <?php echo $l_anDayOfWeek['Tuesday'] ?>,
                                                <?php echo $l_anDayOfWeek['Wednesday'] ?>,
                                                <?php echo $l_anDayOfWeek['Thursday'] ?>,
                                                <?php echo $l_anDayOfWeek['Friday'] ?>,
                                                <?php echo $l_anDayOfWeek['Saturday'] ?>,
                                                <?php echo $l_anDayOfWeek['Sunday'] ?>,
                                            ],
                                            "backgroundColor":[
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                            ],
                                            "borderColor":[
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                            ],
                                            "borderWidth": 1
                                        }]
                                    }});
                            </script>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>


                </div>
            </section>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					Account Information
				</header>
				<div class="panel-body">

                <div class="row">
                        <div class="col-md-6">
                            <canvas id="chart_email_donut" height="200px"></canvas>
                            <script>
                                var chart_email_donut = document.getElementById("chart_email_donut");
                                var myChart = new Chart(chart_email_donut, {
                                    "type":"horizontalBar",
                                    "data":{
                                        "labels":[
                                            "ActiveCampaign",
                                            "Drip",
                                            "ConvertKit",
                                            "Ontraport",
                                            "MailerLite",
                                            "MailChimp",
                                            "Infusionsoft",
                                            "Aweber"
                                        ],
                                        "datasets":[{
                                            "label":"Users",
                                            "data":[
                                                <?php echo $l_anEmail[1] ?>,
                                                <?php echo $l_anEmail[2] ?>,
                                                <?php echo $l_anEmail[3] ?>,
                                                <?php echo $l_anEmail[4] ?>,
                                                <?php echo $l_anEmail[5] ?>,
                                                <?php echo $l_anEmail[6] ?>,
                                                <?php echo $l_anEmail[7] ?>,
                                                <?php echo $l_anEmail[8] ?>
                                            ],
                                            "backgroundColor":[
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                                "#d9edf7",
                                            ],
                                            "borderColor":[
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                                "#31708f",
                                            ],
                                            "borderWidth": 1
                                        }]
                                    }});
                            </script>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
			</section>





        </div>
	</div>

</div>


<!--body wrapper end-->
