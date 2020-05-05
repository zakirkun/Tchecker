
<style>
    .error{
        background-color:#FF876D;
        color:#FE0303;
    }
    .sucess{
        background-color:#BEF68A;
        color:#4D841A;  
    }
    button{
        border:none;
        background:none;
        cursor: pointer;
        color:white;
        width:200px;
        height:40px;
    }
    button:hover{
        background-color:#4f567d;
    }
    #subForm{
        color:white;
        cursor: pointer;
        margin:20px;
        width:150px;
        height:50px;
        border-radius:10px;
        border:2px solid red;
        background:none;
    }
    #subForm:hover{
        background-color:#FE4F1E;
    }
    #tarea{
        width: 100%;
        padding: 20px;
        text-align: center;
        background-color:#2F4F4F;
        color:white;
        resize:none;
        outline:none;
    }
    #s{
        overflow-y:auto;
        text-align:center;
        background-color:#202333;
        width: 50%;
        height:300px;
        float:left;

    }
    #e{
        background-color:#202333;
        overflow-y:auto;
        text-align:center;
        width: 49%;
        height:300px;
        float:right;
    }
    #mid{
        height:200px;
        text-align:center;
        overflow-y:auto;
        background-color:#202333;
        clear:both;
        margin-top:25%;
    }
    #data-sucess{
        
    }
    #data-errors{
  
    }
    footer{
        clear:both;
    }
    #aprovada{
        
    }
</style>

<div class="container">
Please use [CARD]|[MONTH]|[YEAR]|[CVV]<br>
<div>   
    <form id="form" method="post">
        <input type="radio" <?php
            if(isset($_GET['opt']))
                if($_GET['opt'] == "card") echo "checked";
            else
                echo "checked"; 
            ?> name="option" value="cardNumber" id="card">
        <label for="card">Cartão</label>
        
        <input type="radio" <?php if(isset($_GET['opt'])) if($_GET['opt'] == "login") echo "checked";?> name="option" value="loginPass" id="login">
        <label for="login">Login</label>
    </div>
    <div style="text-align:center;">
        <textarea  name="valor" required="required" id="tarea"  cols="40" rows="10"> </textarea><br>
        <input type="submit" id="subForm" value="submit">
    </div>
    </form>
</div>
<div>
    <div id="info" class="container">
        <ul style="list-style:none;">
            carregadas <li class="n-carregadas">0</li>
            aprovadas<li class="n-aprovadas">0</li>
            reprovadas<li class="n-reprovadas">0</li>
            estranhas<li class="n-estranhas">0</li>
            em fila<li class="n-fila">0</li>
        </ul>
        <br>
    </div>
    <div id="s">
        <button style="border-radius:10px;border:2px solid #4EA242;" id="aprovada"> APROVADAS[+]</button> <span class="n-aprovadas">0</span>
        <div id="data-sucess">

        </div>
    </div>

    <div id="e">
    <button style="border-radius:10px ;border:2px solid #E52C1B" id="reprovada">REPROVADAS[-]</button> <span class="n-reprovadas">0</span>
        <div id="data-errors">

        </div>

    </div>

    <div id="mid" class="container">
        
    <button style="border-radius:10px;border:2px solid #C7BF79;" id="estranhas">ESTRANHAS</button> <span class="n-testadas">0</span>
        <div id="data">

        </div>
    </div>
</div>
    <script>
           
           $(document).ready(() => {
     
               $("#aprovada").on("click",()=>{
                   $("#data-sucess").toggle();
               });
       
               $("#reprovada").on("click",()=>{
                   $("#data-errors").toggle();
               });
       
               $("#estranhas").on("click",()=>{
                   $("#data").toggle();
               });

               $("#form").submit(()=>{
               //n-carregadas n-aprovadas n-reprovadas n-estranhas n-fila
                    var ncarregadas = $(".n-carregadas");
                    var naprovadas = $(".n-aprovadas");
                    var nreprovadas = $(".n-reprovadas");
                    var nestranhas = $(".n-estranhas");
                    var nfila = $(".n-fila"); 
                    
                    var desco = $("#data");

                    var option = $("input[name='option']:checked").val();
                    var lista = $("#tarea").val();
                    var linha = lista.split("\n");
                    var total = linha.length;
                    ncarregadas.html(total);
                    var aprovadas = 0;
                    var reprovadas = 0;
                    var desconhecidos = 0;
                    linha.forEach((value,index) =>{
                        setTimeout(()=>{
                            $.ajax({
                                url: "?pot=checkers",
                                type:"POST",
                                async: true,
                                data:{"valor":value,"option":option},
                                success: (result) =>{
                                    if(result.match("APROVADA")){
                                        removelinha();
                                        aprovado(result);
                                        aprovadas++;
                                    }else if(result.match("DESCONHECIDO")){
                                        removelinha();
                                        desconhecido(result);
                                        desconhecidos++
                                    }else{
                                        removelinha();
                                        reprovado(result);
                                        reprovadas++;
                                    }
                                    var fila = parseInt(aprovadas) + parseInt(reprovadas);
                                    nfila.html(fila);
                                    naprovadas.html(aprovadas);
                                    nreprovadas.html(reprovadas);
                                    nestranhas.html(desconhecidos);
                                }
                                
                            });
                        },500 * index);
                    });
                    return false;
                });
           });           
    function aprovado(str){
        $("#data-sucess").append(str + "<br>");
    }
    function reprovado(str){
        $("#data-errors").append(str + "<br>");
    }
    function desconhecido(str){
        $("#data").append(str + "<br>");
    }
    function removelinha() {
        var lines = $("#tarea").val().split('\n');
        lines.splice(0, 1);
        $("#tarea").val(lines.join("\n"));
    }
   </script>