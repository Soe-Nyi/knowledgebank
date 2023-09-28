const shareBtn = document.getElementById('shareBtn')
var id = document.querySelector('.link').value;
shareBtn.addEventListener('click', event => {

  
  if (navigator.share) {
    
    navigator.share({
      text: 'Please read this great article: ',
      url: 'more.php?id='+id
    }).then(() => {
      console.log('Thanks for sharing! By Admi');
    })
      .catch((err) => console.error(err));
  } else {
    
    alert("The current browser does not support the share function. Please, manually share the link")
  }
});