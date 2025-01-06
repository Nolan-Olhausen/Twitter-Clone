function textCounter(field,field2,maxlimit) // for character counters when posting, commenting, etc
{
    var countfield = document.getElementById(field2);
    countfield.value = maxlimit - field.value.length;
}