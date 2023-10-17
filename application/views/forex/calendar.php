
<div class="reg-form-holder">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="license-title">Economic Calendar</h1>
                <div class="calendar-holder">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="calendar-nav">
                                <ul role="tablist" class="queue-tab-list">
                                    <li role="presentation"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" id="t1">Yesterday</a></li>
                                    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" id="t2">Today</a></li>
                                    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" id="t3">Tomorrow</a></li>
                                    <li role="presentation"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab" id="t4">This Week</a></li>
                                    <li role="presentation"><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab" id="t5">Next Week</a></li>
                                    <li role="presentation"><a href="#"><i class="fa fa-calendar"></i></a></li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>

                            <div class="dropdown calendar-drp">
                                <a class="drp-cur-time" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clock-o"></i> Current Time: 01:32 (GMT - 5:00)
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                    <li><a href="#">Sample</a></li>
                                    <li><a href="#">Sample</a></li>
                                    <li><a href="#">Sample</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="calendar-filter-holder">
                                <a class="calendar-filter" href="#" data-toggle="modal" data-target="#esFilter"><i class="fa fa-filter"></i> Filter</a>
                                <p>
                                    All data are streaming and updated automatically.
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="tab1">
                            <div class="table-responsive">
                                <table class="table table-stripped calendar-tab table-hover">
                                    <thead>
                                    <tr>
                                        <th class="ec-time">Time</th>
                                        <th class="ec-cur">Cur.</th>
                                        <th class="ec-imp">Imp.</th>
                                        <th class="ec-events">Event</th>
                                        <th class="ec-actual">Actual</th>
                                        <th class="ec-forecast">Forecast</th>
                                        <th class="ec-prev">Previous</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cnt = count($xml->channel->item);
                                    var_dump($cnt);
                                    ?>
                                    <tr>
                                        <td colspan="7" class="ec-date"><?=$xml->channel->item[0]->pubDate;?></td>
                                    </tr>

                                    <?php

                                    for($i=0; $i<$cnt; $i++)
                                    {
                                        $url 	= $xml->channel->item[$i]->link;
                                        $title 	= $xml->channel->item[$i]->title;
                                        $desc = $xml->channel->item[$i]->description;
                                     ?>

                                        <tr>
                                            <td>01: 00</td>
                                            <td class="f32"><i class="flag jp"></i> <span class="country-cur">JPY</span></td>
                                            <td>
                                                <div class="progress calendar-progress">
                                                    <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="<?=$link?>" data-toggle="modal" data-target="#event" class="calendar-events"><?=$title?></a> <a href="#"><img src="<?= $this->template->Images()?>forex/prelim-release.png" class="prelim-release"></a></td>
                                            <td></td>
                                            <td>107.2</td>
                                            <td>107.2</td>
                                        </tr>
                                    <?php

                                    }

                                    ?>

<!--

                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ch"></i> <span class="country-cur">CHF</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="<?= $this->template->Images()?>forex/revised-release.png" class="revised-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag eu"></i> <span class="country-cur">EUR</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="<?= $this->template->Images()?>forex/speech.png" class="speech"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag us"></i> <span class="country-cur">USD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag gb"></i> <span class="country-cur">GBP</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag hk"></i> <span class="country-cur">HKD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ru"></i> <span class="country-cur">RUB</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ca"></i> <span class="country-cur">CAD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag br"></i> <span class="country-cur">BRL</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag nz"></i> <span class="country-cur">NZD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag cn"></i> <span class="country-cur">CNY</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab2">
                            <div class="table-responsive">
                                <table class="table table-stripped calendar-tab table-hover">
                                    <thead>
                                    <tr>
                                        <th class="ec-time">Time</th>
                                        <th class="ec-cur">Cur.</th>
                                        <th class="ec-imp">Imp.</th>
                                        <th class="ec-events">Event</th>
                                        <th class="ec-actual">Actual</th>
                                        <th class="ec-forecast">Forecast</th>
                                        <th class="ec-prev">Previous</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="7" class="ec-date">Tuesday, August 25, 2015</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag jp"></i> <span class="country-cur">JPY</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/prelim-release.png" class="prelim-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ch"></i> <span class="country-cur">CHF</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/revised-release.png" class="revised-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag eu"></i> <span class="country-cur">EUR</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/speech.png" class="speech"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag us"></i> <span class="country-cur">USD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag gb"></i> <span class="country-cur">GBP</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag hk"></i> <span class="country-cur">HKD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ru"></i> <span class="country-cur">RUR</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ca"></i> <span class="country-cur">CAD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab3">
                            <div class="table-responsive">
                                <table class="table table-stripped calendar-tab table-hover">
                                    <thead>
                                    <tr>
                                        <th class="ec-time">Time</th>
                                        <th class="ec-cur">Cur.</th>
                                        <th class="ec-imp">Imp.</th>
                                        <th class="ec-events">Event</th>
                                        <th class="ec-actual">Actual</th>
                                        <th class="ec-forecast">Forecast</th>
                                        <th class="ec-prev">Previous</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="7" class="ec-date">Wednesday, August 26, 2015</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">No Records.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab4">
                            <div class="table-responsive">
                                <table class="table table-stripped calendar-tab table-hover">
                                    <thead>
                                    <tr>
                                        <th class="ec-time">Time</th>
                                        <th class="ec-cur">Cur.</th>
                                        <th class="ec-imp">Imp.</th>
                                        <th class="ec-events">Event</th>
                                        <th class="ec-actual">Actual</th>
                                        <th class="ec-forecast">Forecast</th>
                                        <th class="ec-prev">Previous</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="7" class="ec-date">Friday, August 28, 2015</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">No Records.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="ec-date">Thursday, August 27, 2015</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">No Records.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="ec-date">Wednesday, August 26, 2015</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">No Records.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="ec-date">Tuesday, August 25, 2015</td>
                                    </tr>

                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag us"></i> <span class="country-cur">USD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag gb"></i> <span class="country-cur">GBP</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag hk"></i> <span class="country-cur">HKD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ru"></i> <span class="country-cur">RUB</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ca"></i> <span class="country-cur">CAD</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag jp"></i> <span class="country-cur">JPY</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/prelim-release.png" class="prelim-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ch"></i> <span class="country-cur">CHF</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/revised-release.png" class="revised-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag eu"></i> <span class="country-cur">EUR</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/speech.png" class="speech"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="ec-date">Monday, August 24, 2015</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag jp"></i> <span class="country-cur">JPY</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/prelim-release.png" class="prelim-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag ch"></i> <span class="country-cur">CHF</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/revised-release.png" class="revised-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag eu"></i> <span class="country-cur">EUR</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="images/speech.png" class="speech"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tab5">
                            <div class="table-responsive">
                                <table class="table table-stripped calendar-tab table-hover">
                                    <thead>
                                    <tr>
                                        <th class="ec-time">Time</th>
                                        <th class="ec-cur">Cur.</th>
                                        <th class="ec-imp">Imp.</th>
                                        <th class="ec-events">Event</th>
                                        <th class="ec-actual">Actual</th>
                                        <th class="ec-forecast">Forecast</th>
                                        <th class="ec-prev">Previous</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="7" class="ec-date">Tuesday, August 25, 2015</td>
                                    </tr>
                                    <tr>
                                        <td>01: 00</td>
                                        <td class="f32"><i class="flag jp"></i> <span class="country-cur">JPY</span></td>
                                        <td>
                                            <div class="progress calendar-progress">
                                                <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#" data-toggle="modal" data-target="#event" class="calendar-events">Sample Event</a> <a href="#"><img src="<?= $this->template->Images()?>forex/prelim-release.png" class="prelim-release"></a></td>
                                        <td></td>
                                        <td>107.2</td>
                                        <td>107.2</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="" class="number">Number of records shown per page</label>
                                    <input type="text" class="form-control round-0 number-text" id="" placeholder="">
                                </div>
                                <button type="submit" class="btn btn-default round-0">Go</button>
                            </form>
                        </div>
                        <div class="col-md-6 calendar-pagination">
                            <nav>
                                <ul class="pagination calendar-pagination">
                                    <li class=""><a href="#" aria-label=""><span aria-hidden="true">&laquo;</span></a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li class=""><a href="#">2</a></li>
                                    <li class=""><a href="#">3</a></li>
                                    <li class=""><a href="#">4</a></li>
                                    <li class=""><a href="#" aria-label=""><span aria-hidden="true">&raquo;</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-legend-holder">
                                <h1 class="legend-title">Legend</h1>
                                <div class="legend1-holder">
                                    <ul>
                                        <li><span class="span"><img src="<?= $this->template->Images()?>forex/speech.png" class="speech-size"></span> Speech</li>
                                        <li><span class="span"><img src="<?= $this->template->Images()?>forex/prelim-release.png"></span> Preliminary Release</li>
                                        <li><span class="span"><img src="<?= $this->template->Images()?>forex/revised-release.png"></span> Revised Release</li>
                                    </ul>
                                </div>
                                <div class="legend1-holder legend2">
                                    <ul>
                                        <li>
                                                <span class="span1">
                                                    <div class="progress calendar-progress">
                                                        <div class="progress-bar progress-bar-low low" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="">
                                                        </div>
                                                    </div>
                                                </span>
                                            Low Volatility Expected
                                        </li>
                                        <li>
                                                <span class="span1">
                                                    <div class="progress calendar-progress">
                                                        <div class="progress-bar progress-bar-warning moderate" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="">
                                                        </div>
                                                    </div>
                                                </span>
                                            Moderate Volatility Expected
                                        </li>
                                        <li>
                                                <span class="span1">
                                                    <div class="progress calendar-progress">
                                                        <div class="progress-bar progress-bar-danger high" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="">
                                                        </div>
                                                    </div>
                                                </span>
                                            High Volatility Expected
                                        </li>
                                    </ul>
                                </div><div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


