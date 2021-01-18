function back(){
    window.history.back();
}
function newpost(tt){
    var nys = document.createElement('div');
    nys.innerHTML ="<br><input type='text' name='subtitle[]' placeholder='Titel'><input type='file' name='image[]' accept='image/x-png,image/gif,image/jpeg'><br><textarea type='text' name='subtext[]' placeholder='Text'></textarea>";
    document.getElementById("pp").appendChild(nys);
}