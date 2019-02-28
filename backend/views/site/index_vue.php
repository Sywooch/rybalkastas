<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 18.05.2018
 * Time: 14:49
 */

$this->title = 'Статистика';

?>


<div id="main">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Статистика по заказам</h3>
                <i v-if="!(bymonth.sets.new.length > 0 && bymonth.sets.cancelled.length > 0 && bymonth.sets.done.length > 0 && bymonth.sets.all.length > 0)" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <br>
            </div><!-- /.box-header -->
            <div class="box-body">
                <canvas id="monthChart"></canvas>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Посещаемость по дням</h3>
                <i v-if="!(users.set.length > 0)" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <br>
            </div><!-- /.box-header -->
            <div class="box-body">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Взятые заказы по дням</h3>
                <i v-if="!(experts.set.length > 0)" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <select v-else class="form-control" v-model="experts_period">
                    <option v-for="period in periods" :value="period.key">{{period.label}}</option>
                </select>
                <br>
            </div><!-- /.box-header -->
            <div class="box-body box-body-flex">
                <div class="box box-solid" style="overflow: auto;width: 20%;display: inline-block;"  v-for="gang in splitManagers">
                    <div class="box-header box-header-small with-border" v-bind:style="{'background-color':gang[0].link.backgroundColor}">
                        <h3 v-on:click="expertsCheckByGang(gang[0].gang)" v-bind:class="{'lt2':!expertsGangUnchecked(gang[0].gang)}" class="box-title">{{gang[0].link.shop}} (с {{gang[0].gang}})</h3>
                    </div>
                    <div class="box-body">
                        <template v-for="expert in gang">
                            <a v-bind:class="{'lt':expert.link.hidden}" v-on:click.prevent="expert.link.hidden ? expert.link.hidden = false : expert.link.hidden = true, updateChart()" href="#">{{expert.name}}</a><br/>
                        </template>

                    </div>
                </div>
            </div>
            <div class="box-body">
                <canvas id="expertsChart"></canvas>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Взятые заказы по дням (по сменам)</h3>
                <i v-if="!(gangs.set.length > 0)" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <select v-else class="form-control" v-model="gangs_period">
                    <option v-for="period in periods" :value="period.key">{{period.label}}</option>
                </select>
                <br>
            </div><!-- /.box-header -->
            <div class="box-body">
                <canvas id="gangsChart"></canvas>
            </div>
        </div>
    </div>
</div>
<style>
    #monthChart, #activityChart{
        width: 100%;
        height: 50vh!important;
    }
    #expertsChart, #gangsChart{
        width: 100%;
        height: 70vh!important;
    }
    .lt {
        text-decoration: line-through;
        color:red;
    }
    .lt:active,.lt:focus{
        text-decoration: line-through;
        color:red;
    }
    h3.box-title.lt2 {
        color: red;
        text-decoration: line-through;
    }
    .box-header-small h3{
        font-size: 80%!important;
        cursor: pointer;
    }
    .box-body-flex{
        display: flex;
        column-count: 4;
        flex-wrap: wrap;
    }
</style>
<?php
$this->registerJsFile('/js/pages/main.js');
?>