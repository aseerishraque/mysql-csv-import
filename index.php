<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <title>Import CSV!</title>
  </head>
  <body>
    <h1>Import MySql Data Via CSV!</h1>

    <!-- Online Code Start -->

        <?php
    // Load the database configuration file
    include_once 'dbConfig.php';

    // Get status message
    if(!empty($_GET['status'])){
        switch($_GET['status']){
            case 'succ':
                $statusType = 'alert-success';
                $statusMsg = 'Members data has been imported successfully.';
                break;
            case 'err':
                $statusType = 'alert-danger';
                $statusMsg = 'Some problem occurred, please try again.';
                break;
            case 'invalid_file':
                $statusType = 'alert-danger';
                $statusMsg = 'Please upload a valid CSV file.';
                break;
            default:
                $statusType = '';
                $statusMsg = '';
        }
    }
    ?>

    <!-- Display status message -->
    <?php if(!empty($statusMsg)){ ?>
    <div class="col-xs-12">
        <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
    </div>
    <?php } ?>

    <div class="row">
        <!-- Import link -->
        <div class="col-md-12 head">
            <div class="float-right">
                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
            </div>
        </div>
        <!-- CSV file upload form -->
        <div class="col-md-12" id="importFrm" style="display: none;">
            <form action="importData.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
            </form>
        </div>

        <!-- Data list table --> 
        <table id="table_id" class="table table-striped table-bordered m-auto">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Identifier</th>
                    <!-- <th>Portfolio_manager</th> -->
                    <th>Tickers</th>
                    <th>Type_Description</th>
                    <th>Quantity</th>
                    <th>Value</th>
                    <th>Color</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Get member rows
            $result = $db->query(" 
            SELECT *,
            (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1) as latest_company_trade_date,
            IF(DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    ) < 0 , 
               DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
               *-1, 
              DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
              ) as diff
            ,
            IF(Identifier != 'company', IF((
            IF(DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    ) < 0 , 
               DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
               *-1, 
              DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
              )
            ) <= 3, 'red', IF((
            IF(DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    ) < 0 , 
               DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
               *-1, 
              DATEDIFF(Date, 
                     (SELECT Date from tmg_trader_trades_year_month_v0 WHERE Identifier = 'company' ORDER BY Date DESC LIMIT 0,1)
                    )
              )
            ) <=5, 'amber', 'green')), 'blue') as color from tmg_trader_trades_year_month_v0
            
            
            ");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
            ?>
                <tr>
                    <td><?php echo $row['Date']; ?></td>
                    <td><?php echo $row['Identifier']; ?></td>
                    <!-- <td><?php //echo $row['Portfolio_manager']; ?></td> -->
                    <td><?php echo $row['Tickers']; ?></td>
                    <td><?php echo $row['Type_Description']; ?></td>
                    <td><?php echo $row['Quantity']; ?></td>
                    <td><?php echo $row['Value']; ?></td>
                    <td><?php echo $row['color']; ?></td>
                </tr>
            <?php } }else{ ?>
                <tr><td colspan="6">No Data found...</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Show/hide CSV upload form -->
    <script>
    function formToggle(ID){
        var element = document.getElementById(ID);
        if(element.style.display === "none"){
            element.style.display = "block";
        }else{
            element.style.display = "none";
        }
    }
    </script>    


    <!-- Online Code End -->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
  </body>
</html>