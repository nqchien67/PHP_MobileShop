<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<div class="grid_10">
  <div class="box round first grid">
    <h2> Thống kê doanh thu</h2>
    <div class="container">

      <div class="bg-light border rounded mt-1 p-2">
        <div class="row">
          <h1 class="col-1">Bộ lọc</h1>
          <div class="col-3">
            <select id="selectDate" class="form-select"></select>
          </div>
        </div>

        <div class="row">
          <div class="col-4">
            <label for="dtp_input2" class="control-label">Từ ngày</label>
            <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtpFrom" data-link-format="yyyy-mm-dd">
              <input class="form-control" size="16" type="text" value="" readonly>
              <span style="width: auto;" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
            <input type="hidden" id="dtpFrom" value="" /><br />



          </div>
          <div class="col-4">
            <label for="dtp_input2" class=" control-label">Đến ngày</label>
            <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtpTo" data-link-format="yyyy-mm-dd">
              <input class="form-control" size="16" type="text" value="" readonly>
              <span style="width: auto;" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
            <input type="hidden" id="dtpTo" value="" /><br />
          </div>
          <div class="col-4 d-flex align-items-center">
            <button id="btnApply" type="button" class="btn btn-success ">Áp dụng</button>
          </div>
        </div>
      </div>

      <div class="mt-3 container-fluid bg-light border rounded">
        <div class="border-bottom row">
          <h4 id="price" class="col font-weight-bold">Tổng tiền: </h4>
          <h4 id="total" class="col font-weight-bold">Tổng đơn hàng: </h4>
        </div>
        <canvas id="chart"></canvas>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="js/datetimepicker/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@2.2.0/build/global/luxon.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="js/index.js" charset="UTF-8"></script>
<?php include 'inc/footer.php'; ?>