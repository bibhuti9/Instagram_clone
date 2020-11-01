<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#inner_root{
	border:1px solid black;
	padding:10px;
	border-radius:10px;
	max-width:150px;
	margin:10px;
}
.header{
	position:relative;
	display:flex;
	border-bottom:1px solid black;
	box-shadow:1px 1px 4px 1px lightgrey;
	padding:5px;
}
form{
	width:300px;
	height:20px;
	display:flex;
}
	</style>
<script src="https://www.gstatic.com/firebasejs/7.10.0/firebase.js"></script>
   <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js'></script>
</head>
<body>
	<div class="root">
		<div class="header">
			<i style="width:150px;">Instagram</i>
			<form enctype="multipart/form-data">
				<input style="
					width:100px;
					margin-right:10px;
					border:1px solid black;
					outline:0;
					border-radius:5px;
				" type="text" id="_post_name" placeholder="Post Name">

				<input
				style="
					width:55px;
					outline:0;
					margin-right:80px;
				"
				 type="file" id="image" accept="image/*">
				<button style="
					border:1px solid black;
					border-radius:10px;
					background-color:#ed7aa8;
				" type="button" onclick="upload_post()">+</button>
			</form>
		</div>
		<div id="new_Post">
			
		</div>
	</div>
	
		<script>
		  // Your web app's Firebase configuration
		  var firebaseConfig = {
		    apiKey: "AIzaSyBsW28n0oE0Ynrc-6mrXL_JGErzQTrIplc",
		    authDomain: "instagramclone-63445.firebaseapp.com",
		    databaseURL: "https://instagramclone-63445.firebaseio.com",
		    projectId: "instagramclone-63445",
		    storageBucket: "instagramclone-63445.appspot.com",
		    messagingSenderId: "515077901780",
		    appId: "1:515077901780:web:a469faf9c00e9ab9cd1a41"
		  };
		  // Initialize Firebase
		  firebase.initializeApp(firebaseConfig);

		  	const sender_id=101;
			const sender_name="biku";

			
			// const root_post=firebase.database().ref("Post").set({});
			
			const root_post=firebase.database().ref("Post/");
			const second_root_id=root_post.child(sender_id);

				// 	root_post.on('value',function(snapshot){
				// 	var black_ele="";
				// 	snapshot.forEach((val)=>{			// this loop is used for retuen key(101) obj
				// 		val.forEach((val)=>{	// this loop is used for return key(post_name) obj
				// 		//
				// 	  	 	let image_url;
				// 		 	var storageRef=firebase.storage().ref("image/"+val.key);
				// 		 	storageRef.getDownloadURL().then(function(downloadURL){
				// 				// get your upload url 
				// 				image_url=downloadURL;
				// 				var ele=document.getElementById("new_Post");
				// 				ele.innerHTML="";
				// 				black_ele+="<div id='inner_root'>"
				// 				black_ele+="<p id='post_name'>"+val.val().sender_post_name+"</p>";
				// 				black_ele+="<img width='150px' src='"+image_url+"'>";
				// 				black_ele+="</div>";
				// 				ele.innerHTML+=black_ele;
				// 			});
				// 		});	
				// 	});
				// });

			
			function upload_post(){
				const sender_post_name=document.getElementById("_post_name").value;
				var image=document.getElementById("image").files[0];
				var imageName=image.name;
			 	const database =firebase.database().ref("Post/");
			 	const sender_id_child=database.child(sender_id);
			 	// set the data
				 
				var image_root=firebase.storage().ref("image/"+sender_post_name);
				// Above upload the image storageRef
				 var uploadTask=image_root.put(image);	
				 uploadTask.on('state_changed',function(snapshot){
					// get progress bar
					var progressBar=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
					console.log(progressBar);
				 },function(error){
					console.log(error.message);
				 },function(){
					// handle sucessfull upload
					uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL){
						// get your upload url 
							console.log(downloadURL);
							sender_id_child.child(sender_post_name).set({
								"sender_name":sender_name,
								"sender_post_name":sender_post_name,
								"sender_image_name":imageName,
								"image_url":downloadURL
				 			});
						});
					});
				}
					root_post.on('value',function(snapshot){
					var black_ele="";
					snapshot.forEach((val)=>{			// this loop is used for retuen key(101) obj
						val.forEach((val)=>{	// this loop is used for return key(post_name) obj
						//
							var ele=document.getElementById("new_Post");
								ele.innerHTML="";
								black_ele+="<div id='inner_root'>"
								black_ele+="<p id='post_name'>"+val.val().sender_post_name+"</p>";
								black_ele+="<img width='150px' src='"+val.val().image_url+"'>";
								black_ele+="</div>";
								ele.innerHTML+=black_ele;						 	
						});	
					});
				});
		</script>
</body>
</html>