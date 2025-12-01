<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Transaction Details</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <table class="table">
          <tr><th>Title</th><td id="m_title"></td></tr>
          <tr><th>Wallet</th><td id="m_wallet_type"></td></tr>
          <tr><th>Type</th><td id="m_type"></td></tr>
          <tr><th>Amount</th><td id="m_amount"></td></tr>
          <tr><th>Status</th><td id="m_status"></td></tr>
          <tr><th>Date</th><td id="m_date"></td></tr>
          <tr><th>Notes</th><td id="m_notes"></td></tr>
        </table>

      </div>

    </div>
  </div>
</div>

<script>
document.getElementById('detailModal').addEventListener('show.bs.modal', function (e) {
    let btn = e.relatedTarget;
    let data = JSON.parse(btn.getAttribute('data-history'));

    document.getElementById('m_title').innerText   = data.title;
    document.getElementById('m_wallet_type').innerText = data.wallet_type;
    document.getElementById('m_type').innerText    = data.type;
    document.getElementById('m_amount').innerText  = data.amount;
    document.getElementById('m_status').innerText  = data.status;
    document.getElementById('m_date').innerText    = data.date;
    document.getElementById('m_notes').innerText   = data.notes ?? "-";
});
</script>
