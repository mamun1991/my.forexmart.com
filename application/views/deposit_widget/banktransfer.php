<div class="col-lg-3 col-md-3">
	<div class="bankdep-holder arabic-bankdep-holder">
		<a href="<?= FXPP::loc_url('deposit/bank-transfer');?>"><img src="<?= $this->template->Images()?>banktransfer.png" class="img-reponsive" width="120px"></a>
		<p class="bankdep-text">
			<?= lang('BankTransfer_desc');?>
			<br/>
			<a href="<?= FXPP::loc_url('deposit/bank-transfer');?>">
				<?= lang('dbt_desc'); ?>
			</a>
		</p>
	</div>
</div>