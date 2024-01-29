/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import {Tooltip,Toast,Popover} from 'bootstrap';
import './bootstrap';
import jquery from 'jquery';
import $ from 'jquery';
import 'jquery-ui';
// const $ = require('jquery'); 
//   window.$ =$ ;
global.$ = global.jQuery = $;
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap/dist/js/bootstrap.min.js';



// start the Stimulus application

import axios from 'axios';
// import autocomplete from 'jquery-ui';
// import 'autocomplete';
// import jquery-ui from 'jquery-ui';
// window.prototype.$ = $;
$(document).ready(function () {
    $("#addBlocNote").on('click',function(e){
        e.preventDefault();
        console.log("here");
        var form= $(this).closest('form');
        var todo= form.find('#todo').val();
        console.log(todo);
        let data = {
            todo: todo,
            // ... autres données
        };
        if(todo !== ''){
            axios.post('/add/bloc-note',data)
            .then(response => {
                console.log(response.data);
                window.location.href = "/bloc-note";
                // Traitez les données de l'utilisateur ici
            })
            .catch(error => {
                console.error(error);
                // Gérez les erreurs ici
            });
        } 
    })

    function addBlocNote(){
       
    }
    $('.edit_note').click(function(e) {
        // e.preventDefault();
        console.log('modal');
        var tr= $(this).closest('tr');
        var id= tr.find('.hiddenContenuId').val();
        var todo= tr.find('.hiddenContenuValue').val();
        var editUrl = $('.dataEditUrl').data('edit-url');
  console.log(editUrl);   
        var data=`  
        <div class="modal-dialog">
        <div class="modal-content" >
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Titre de la Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="form-inline" action="${editUrl}" method="POST" > 
        <div class="row">
        <div class="col-md-10">
        <div class="form-group">

            <input type="text" name="editTodo" class="form-control" id="editTodo" value="`+todo+`" />
        </div>
        </div>
        <div class="col-md-1">
        <div class="form-group">

            <button type="submit" id="editBlocNote"  class="btn btn-primary">editer</button>
        </div>
        </div>
        </div>
    </form>  

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <!-- Autres boutons de la modal si nécessaire -->
        </div>
        </div>
    </div>`;
        // Affichez la modal avec l'identifiant #myModal
        
        $('#createModal').html(data); 
        // $('#createModal').modal('show');
    });

    $('.showHistorique').click(function(e) {
        // e.preventDefault();
        console.log('modal');
        axios.get('/did/bloc-note')
        .then(response => {
            console.log(response.data.data);
            let listdid=response.data.data;
        
        $('#historiqueModal').html(listdid); 
        })
        .catch(error => {
            console.error(error);
            // Gérez les erreurs ici
        });

    
        // $('#createModal').modal('show');
    });


    $('#editBlocNote').click(function(e) {
        e.preventDefault();
        console.log('clidlke edit');
    });
});