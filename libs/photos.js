var currentPhoto = 0;

$(document).ready(function() {
   updatePhoto();
 });


function updatePhoto(){
  
  //get the vars
  var photo = $('#photo');
  var out = '';
  var created = new Date(photos[currentPhoto].created*1000);
  
  //generate the photo output
  out+= '<a href="javascript: ;" onclick="skipToPreviousPhoto();">< previous</a> '
  out+= 'Photo ' + (currentPhoto+1) + ' out of ' + photos.length;
  out+= ' <a href="javascript: ;" onclick="skipToNextPhoto();">next ></a>'
  out+= '<br/>';
  out+= '<img src="' + photos[currentPhoto].src_big + '"></img>';
  
  photo.html(out);
}

function skipToNextPhoto(){
  if(currentPhoto+1 > photos.length) currentPhoto = 0;
  else currentPhoto++;
  
  updatePhoto();
}

function skipToPreviousPhoto(){
  if(currentPhoto-1 < 0) currentPhoto = photos.length;
  else currentPhoto--;
  
  updatePhoto();
}