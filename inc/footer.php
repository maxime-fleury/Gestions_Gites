<footer>
    <div class='container'>
        <button href='index.php?c=Chambre'>Chambre</button>
        <button href='index.php?c=Appartement'>Appartement</button>
        <button href='index.php?c=Maison'>Maison</button>
    </div>
    <div class='container'>
        <img class='footer_img' alt='logo' src='../img/house.png'></img>
    </div>
    <div class='container'>
        <img class='footer_img' alt='logo' src='../img/facebook.png'></img>
        <img class='footer_img' alt='logo' src='../img/twitter.png'></img>
        <img class='footer_img' alt='logo' src='../img/instagram.png'></img>
    </div>
</footer>
<style>
*{
    margin:0;
    padding:0;
}
footer{
    background: #79C99E;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    width: 100vw;
    overflow-x: hidden;
}
.footer_img{
    width:40px;
}
button, .footer_img{
    border:none;
    padding-left:25px;
    padding-right:25px;
    background: #79C99E;
}
button:hover{
    background:#fff;
}
.container{
    display:flex;
    justify-content:center;
}
</style>
</body>
</html>