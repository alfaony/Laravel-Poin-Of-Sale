 
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Agenda - Daengweb</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
​
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
​
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container" style="padding-top: 20px">
        <div class="row" id="dw">
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daftar Agenda</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Agenda</label>
                            <input type="text" class="form-control" placeholder="Agenda apa hari ini ?" v-model="agenda">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" v-model="deskripsi">
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date"  class="form-control" v-model="jadwal">
                        </div>
                        <hr>
​
                        <div class="agenda">
                            <h3><i class="fa fa-bullhorn"></i> @{{ agenda }}</h3>
                            <p><i class="fa fa-calendar"></i> @{{ jadwal }}</p>
                            <p>@{{ deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
​
    <script type="text/javascript" src="https://unpkg.com/vue@2.5.6/dist/vue.js"></script>
    <script type="text/javascript">
        new Vue({
            el: '#dw',
            data: {
                agenda: '',
                deskripsi: '',
                jadwal: ''
            }
        }); 
    </script>
</body>
</html>