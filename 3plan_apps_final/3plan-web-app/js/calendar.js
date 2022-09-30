var tabelle = document.getElementById("kalender");
        
        var totalRowCount = tabelle.rows.length;
        var datoutput;
        var selecteddat;
        var selected = 0;
        var old;
        const   datum = new Date();
        var datum_monat = datum.getMonth() + 1;
        var datum_jahr = datum.getFullYear();
        var result = [];

        function setResultArray(arr) {
            this.result = arr;
        }
        
        //navigationsknöpfe erstellen
        nextmonth = document.createElement('button');
        prevmonth = document.createElement('button');
        
        nextmonth.id = 'nextm';
        prevmonth.id = 'prevm';
        
        //buttons einfügen
        
        nextmonth.innerHTML = "";
        prevmonth.innerHTML = "";
        
        nextmonth.setAttribute('aria-label', 'Go to next month');
        prevmonth.setAttribute('aria-label', 'Go to previous month');
        
        document.body.appendChild(nextmonth);
        document.body.appendChild(prevmonth);
        
        sessionStorage.setItem('D',datum);
        sessionStorage.setItem('StartDatum', datum.toDateString());
        
        Kalender(datum_monat, datum_jahr, 'kalender');
        
        function Kalender (Monat, Jahr, Kalender_id) {
            const monatsname = new Array("January", "February", "March", "April", "May", "June", "Juli", "August", "September", "October", "November", "December");
            const tagname = new Array("Mo", "Tue", "Wed", "Thu", "Fr", "Sa", "Sun");
        
        
            // Nun folgt das aktuelle Datum
        
            const aktuell = new Date();
            // Erstmal keine Hervorhebung, da -1 nicht im Kalender erscheint
            let aktuellerTag = -1;
            if ((aktuell.getFullYear() == Jahr) && (aktuell.getMonth() + 1 == Monat)) {
                aktuellerTag = aktuell.getDate();
            }
        
            // Nun wird der Wochentag des ersten Tags im Monat ermittelt
            const Zeit = new Date(Jahr, Monat - 1, 1);
            const Start = (Zeit.getDay() + 6) % 7;
        
            // Anzahl der Tage im Monat
            // Monate haben nicht mehr als 31 Tage
            let ende = 31;
        
            // Monate behandeln, die nicht 31 Tage haben
            if (Monat == 4 || Monat == 6 || Monat == 9 || Monat == 11) --ende;
        
            if (Monat == 2) {
            ende = ende - 3;
            // Februar hat in Schaltjahren 29 Tage
            if (Jahr %   4 == 0) Stop++;
            if (Jahr % 100 == 0) Stop--;
            if (Jahr % 400 == 0) Stop++;
            }
        
            // Tabelle wird bearbeitet
            const tabelle = document.getElementById(Kalender_id);
            if (!tabelle) return false;
        
            // Tabelle Header
            const caption = tabelle.createCaption();
            caption.innerHTML = '<div class="month h2-app" id="testt1">' + monatsname[Monat - 1] + " " + Jahr + '</div>';
            document.getElementById('testt1').appendChild(nextmonth);
            document.getElementById('testt1').appendChild(prevmonth);
        
            // Tabelle Head
            const headRow = tabelle.insertRow(0);
            for (var i = 0; i < 7; i++) {
                var cell = headRow.insertCell(i);
                cell.innerHTML = '<div class="big-p-app">' + tagname[i] + '</div>';
            }
        
            // Tag ermitteln
            let tagnumber = 1;
        
            // Monate gehen über 4-6 Wochen
            // Über Tabelle iterieren
            for (let i = 0; tagnumber <= ende; i++) {
                let row = tabelle.insertRow(1 + i);
                
        
                for (let j = 0; j < 7; j++) {
                let cell = row.insertCell(j);
                
                    // Zellen vor dem Start und Zeilen nach dem Ende werden leer
                    if (((i == 0) && (j < Start)) || (tagnumber > ende)) {
                        cell.innerHTML = ' ';
                    }
                    else {
                        // Zellen mit Tag befüllen
                        cell.innerHTML = '<div class="dayblock regular-p-app">' + tagnumber + '</div>';
                        cell.className = 'tag';
                        cell.innerHTML += '<div class="dotcontainer"></div>';
                        
                        
                        //  aktueller Tag mit Klasse heute markiert
                        if (tagnumber == aktuellerTag) {
                            cell.className = cell.className + ' aktuell';
                            cell.id = "at";
                        }
                        tagnumber++;
                    }
                }
            }
            
            return true;
            
        }
        var tabelle = document.getElementById("kalender");
        var totalRowCount = tabelle.rows.length;
        
        function changeAktuell(){
            document.getElementById("at").style.backgroundColor = "rgb(250,250,250)";
            document.getElementById("at").style.color = "rgb(71,71,71)";
        }
        function markieren(){
            
                if (datum_monat == Date().getMonth){
                    changeAktuell();
                }
                else{           
                }
            
                if (selected < 1) {
                //handle click
                if (old == null){
            
                }else{
                    old.style.backgroundColor = "rgb(250,250,250)";
                    old.style.color = "rgb(71, 71, 71)";
                }
            
                let target = event.target;
                selecteddat = event.target.innerHTML;
                datoutput = new Date(datum_jahr,datum_monat - 1,selecteddat);
                document.getElementById("seldat").innerHTML = datoutput;
                sessionStorage.setItem('D',datoutput);
                sessionStorage.setItem('StartDatum', datoutput.toDateString());
                old = target;
                target.style.backgroundColor = "rgba(77, 113, 174, 0.814)";
                target.style.color = "white";
                
                selected ++;
                }
                
                else{
                    old.style.backgroundColor = "rgb(250,250,250)"
                    old.style.color = "rgb(71, 71, 71)";
                    let target = event.target;
                    selecteddat = event.target.innerHTML;
                    datoutput = new Date(datum_jahr,datum_monat - 1,selecteddat);
                    document.getElementById("seldat").innerHTML = datoutput;
                    sessionStorage.setItem('D',datoutput);
                    sessionStorage.setItem('StartDatum', datoutput.toDateString());
                    old = target;
                    target.style.backgroundColor = "rgba(77, 113, 174, 0.814)";
                    target.style.color = "white";
                    selected --;
                }    
        }
        
        function markup(){
            //setzt für jedes element einen onclicklistener
            document.querySelectorAll('.tag').forEach(item => {
            item.addEventListener('click', markieren);
        })
        }
        
        function clickHandler1(event) {
            totalRowCount = tabelle.rows.length;
            tabelle.deleteCaption();
            for (let i = 0; i < totalRowCount; i++ ){
                tabelle.deleteRow(0);
            }
            if (datum_monat == 12){
                datum_monat = 0;
                datum_jahr += 1;
            }
            Kalender(datum_monat + 1, datum_jahr , 'kalender');
            datum_monat = datum_monat +1;

            addEventDot();
        }
        nextmonth.addEventListener('click', clickHandler1);
        
        function clickHandler2(event) {
            totalRowCount = tabelle.rows.length;
            tabelle.deleteCaption();
            for (let i = 0; i < totalRowCount; i++ ){
                tabelle.deleteRow(0);
            }
            if (datum_monat == 1){
                datum_monat = 13;
                datum_jahr -= 1;
            }
            Kalender(datum_monat - 1, datum_jahr, 'kalender');
            datum_monat = datum_monat - 1;

            addEventDot();
        }
        prevmonth.addEventListener('click', clickHandler2);

        function addEventDot() {
            for (let i = 0; i < result.length; i++) {
                var date = new Date(result[i][0]);
                
                if (datum_monat == date.getMonth() + 1 && datum_jahr == date.getFullYear()) {
                    let dayCount = 1;
                    for (let y = 1; y < tabelle.rows.length; y++) {
                        
                        for (let x = 0; x < tabelle.rows[y].cells.length; x++) {
                            let field = tabelle.rows[y].cells[x];

                            // überprüfen ob Tag zu altem Monat gehört
                            if (field.innerHTML === " ") {
                                continue;
                            }

                            if (dayCount == date.getDate()) {
                                var dotContainer = field.getElementsByClassName("dotcontainer");
                                dotContainer[0].innerHTML += '<div class="dot" style="background-color:'+ result[i][2] +';"><div class="dot-body small-p-app">' + result[i][1] + '</div></div>';
                            }
                            dayCount++;

                        }
                    }

                }
            }
        }