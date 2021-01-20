            <!--footer section start-->
            <footer>
                &copy; <?php echo date('Y') ?> - <?php echo $g_aaSettings['title']['value']; ?>
            </footer>
            <!--footer section end-->

        </div>
        <!-- body content end-->
    </section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/fe/js/bootstrap.min.js"></script>
<script src="/fe/js/modernizr.min.js"></script>

<!--jquery-ui-->
<script src="/fe/js/jquery-ui.min.js" type="text/javascript"></script>

<!--Nice Scroll-->
<script src="/fe/js/jquery.nicescroll.js" type="text/javascript"></script>

<!--switchery-->
<script src="/fe/js/switchery/switchery.min.js"></script>
<script src="/fe/js/switchery/switchery-init.js"></script>

<!--Chart JS-->
<script src="/fe/js/chart-js/chart.js"></script>

<!--tinymce-->
<script src="/fe/js/tinymce/tinymce.min.js"></script>

<!--color picker-->
<script src="/fe/js/jqColorPicker.min.js"></script>

<!--common scripts for all pages-->
<script src="/fe/js/scripts.js"></script>

<script>

    jQuery(document).ready(function(){

		tinymce.init({
			selector:'.tinymce',
			height : 300,
			plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			],
			toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		});
    });

</script>


</body>
</html>
