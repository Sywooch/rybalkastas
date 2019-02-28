<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-cogs"></i>
        <h3 class="box-title">Выборка пользователей</h3>
    </div><!-- /.box-header -->
    <div class="box-body" id="actions">
        <form method="post" action="<?= \yii\helpers\Url::to(['get-users']) ?>">
            <label>Минимальная сумма всех заказов</label>
            <?= \yii\helpers\Html::textInput('min_sum', !empty($_POST['min_sum'])?$_POST['min_sum']:'', ['class' => 'form-control']) ?>


            <div>
                <br/>
                <br/>
                <br/>
                <button class="btn btn-success pull-right">Выбрать</button>
                <div class="clearfix"></div>
            </div>
        </form>

        <?php if(!empty($users)):?>
            <div>
                <br/>
                <button class="btn btn-success pull-right" onclick="javascript:xport.toCSV('testTable');">Экспорт</button>
            </div>
            <table id="testTable" class="table table-hover table-striped">
                <?php foreach ($users as $user):?>
                    <tr>
                        <td><?=$user['customerID']?></td>
                        <td><?=$user['user_phone']?></td>
                        <td><?=$user['customer_email']?></td>
                        <td><?=$user['customer_firstname']?></td>
                        <td><?=$user['customer_lastname']?></td>
                        <td><?=$user['sum']?> rub.</td>

                    </tr>
                <?php endforeach;?>
            </table>
        <?php endif;?>
    </div>
</div>

<script>
    var xport = {
        _fallbacktoCSV: true,
        toXLS: function(tableId, filename) {
            this._filename = (typeof filename == 'undefined') ? tableId : filename;

            //var ieVersion = this._getMsieVersion();
            //Fallback to CSV for IE & Edge
            if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
                return this.toCSV(tableId);
            } else if (this._getMsieVersion() || this._isFirefox()) {
                alert("Not supported browser");
            }

            //Other Browser can download xls
            var htmltable = document.getElementById(tableId);
            var html = htmltable.outerHTML;

            this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
        },
        toCSV: function(tableId, filename) {
            this._filename = (typeof filename === 'undefined') ? tableId : filename;
            // Generate our CSV string from out HTML Table
            var csv = this._tableToCSV(document.getElementById(tableId));
            // Create a CSV Blob
            var blob = new Blob([csv], { type: "text/csv" });

            // Determine which approach to take for the download
            if (navigator.msSaveOrOpenBlob) {
                // Works for Internet Explorer and Microsoft Edge
                navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
            } else {
                this._downloadAnchor(URL.createObjectURL(blob), 'csv');
            }
        },
        _getMsieVersion: function() {
            var ua = window.navigator.userAgent;

            var msie = ua.indexOf("MSIE ");
            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
            }

            var trident = ua.indexOf("Trident/");
            if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf("rv:");
                return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
            }

            var edge = ua.indexOf("Edge/");
            if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
            }

            // other browser
            return false;
        },
        _isFirefox: function(){
            if (navigator.userAgent.indexOf("Firefox") > 0) {
                return 1;
            }

            return 0;
        },
        _downloadAnchor: function(content, ext) {
            var anchor = document.createElement("a");
            anchor.style = "display:none !important";
            anchor.id = "downloadanchor";
            document.body.appendChild(anchor);

            // If the [download] attribute is supported, try to use it

            if ("download" in anchor) {
                anchor.download = this._filename + "." + ext;
            }
            anchor.href = content;
            anchor.click();
            anchor.remove();
        },
        _tableToCSV: function(table) {
            // We'll be co-opting `slice` to create arrays
            var slice = Array.prototype.slice;

            return slice
                .call(table.rows)
                .map(function(row) {
                    return slice
                        .call(row.cells)
                        .map(function(cell) {
                            return '"t"'.replace("t", cell.textContent);
                        })
                        .join(";");
                })
                .join("\r\n");
        }
    };
</script>