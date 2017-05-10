function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("Text", ev.target.text);
}

function dragTemplate(ev) {
    ev.dataTransfer.setData("Text", ev.target.dataset.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("Text");
    ev.target.value = ev.target.value + "##template"+data+"##";
}