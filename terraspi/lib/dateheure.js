



function heureGMT()
    {
    krucial = new Date;
    heure = krucial.getHours();
    min = krucial.getMinutes();
    sec = krucial.getSeconds();
    jour = krucial.getDate();
    mois = krucial.getMonth()+1;
    annee = krucial.getFullYear();
    if (sec < 10)
        sec0 = "0";
    else
        sec0 = "";
    if (min < 10)
        min0 = "0";
    else
        min0 = "";
    if (heure < 10)
        heure0 = "0";
    else
        heure0 = "";
    DinaHeure = heure0 + heure + ":" + min0 + min;// + ":" + sec0 + sec;
    which = DinaHeure
    if (document.getElementById){
        document.getElementById("heure").innerHTML=which;
    }
    setTimeout("heureGMT()", 1000)
    
    }
    
window.onload = heureGMT;

function date(id)
{
        date = new Date;
        annee = date.getFullYear();
        moi = date.getMonth();
        mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
        j = date.getDate();
        jour = date.getDay();
        jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        resultat = ''+jours[jour]+' '+j+' '+mois[moi]+' '+annee;
        document.getElementById(id).innerHTML = resultat;
        setTimeout('date("'+id+'");','1000');
        return true;
}
 function heure(id)
{
        date = new Date;
        annee = date.getFullYear();
        moi = date.getMonth();
        mois = new Array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
        j = date.getDate();
        jour = date.getDay();
        jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        resultat = +h+':'+m+':'+s;
        document.getElementById(id).innerHTML = resultat;
        setTimeout('heure("'+id+'");','1000');
        return true;
}



