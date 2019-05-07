    <!-- Bootstrap Core JavaScript -->
    <script src="<?= url('/'); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- datatables -->
    <script src="<?= url('/'); ?>/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= url('/'); ?>/vendor/datatables/js/dataTables.bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= url('/'); ?>/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- jstree -->
    <script src="<?= url('/'); ?>/vendor/jstree/dist/jstree.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= url('/'); ?>/dist/js/sb-admin-2.js"></script>
    <script src="<?= url('/'); ?>/js/lib-popup.js"></script>


    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('document').ready(function(){
        $('#datatable').DataTable();
      })
    </script>

    <!-- Custom Popup JavaScript -->
    <div id="errorPanel">
      <div id="errorOverlay">
        <!-- <i class="fa fa-exclamation-triangle"></i> <span>Data Error!</span> -->
      </div>
      <div id="errorContent">
        <div class="infoError">
            <i class="glyphicon glyphicon-warning-sign"></i> <span>Data Error!</span>
          </div>
        
        <div id="errorMsg">
          <!-- <i class="fa fa-exclamation-triangle"></i> <span>Data Error!</span> -->
        </div>

        <div class="buttonerror">
          <button id="btnOkError">OK</button>
        </div>

      </div>
    </div>


    <div id="confirmPanel">
      <div id="confirmOverlay">
      </div>
      <div id="confirmContent">
        <div class="info">
        <i class="glyphicon glyphicon-question-sign"></i> <span>Confirmation!</span>
        </div>

        <div id="confirmMsg">
        </div>

        <div class="buttonConfirm">
          <button id="btnYesConfirm">Yes</button>
          <button id="btnNoConfirm">No</button>
        </div>

      </div>
    </div>

    <div id="infoPanel">
      <div id="infoOverlay">
      <!-- <i class="fa fa-exclamation-triangle"></i> <span>Data info!</span> -->
      </div>
      <div id="infoContent">
        <div class="infoinfo">
          <i class="glyphicon glyphicon-info-sign"></i> <span>Data info!</span>
        </div>

        <div id="infoMsg">
        <!-- <i class="fa fa-exclamation-triangle"></i> <span>Data info!</span> -->
        </div>

        <div class="buttoninfo">
          <button id="btnOkInfo">OK</button>
        </div>

      </div>
    </div>