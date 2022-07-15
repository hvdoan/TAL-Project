<div class="page" id="containerForumFront"></div>

<div id="ctnForumFrontForm"></div>

<script type="text/javascript">
	let urlParams = new URLSearchParams(window.location.search);
	let forum = urlParams.get('forum');
	$("#containerForumFront").ready(displayForumFront(forum));
</script>