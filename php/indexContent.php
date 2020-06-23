<div id="navUP"></div>
<div class="height650" id="bg-picIndex1" >
    <!-- //bg -->
</div>

<div class=" mainDiv bg-grey">
    <!-- sticky -->
    <div  class="text-center sticky">
        <h4> <strong>Focimezek</strong> - A&nbspgyűjteményem</h4>
    </div>
    <!-- A honlap célja -->
    <div id="aHonlapCelja"></div><br>
    <div class="row" >
        <div class="col-8">
            <h2>A honlap célja</h2>
            <h4>Megosztani Veletek a gyűjteményt, böngésszetek kedvetekre! </h4>
            <p>
                Sziasztok, Kaiser Rezső vagyok. A mezeket nagyon régóta gyűjtöm, a focizás mellett ez az egyik kedvenc elfoglaltságom.<br>
                .... <br>
                .... <br>
                ....
            </p>
            <button class="btn btn-secondary pull-left">LIKE</button>
                                <!-- LÁJKOLJ- adatbázisból kiolvassa, lájkszámláló -->
        </div>
        <div class="col-3">
            <img class="img img-rounded" src="public/resources/pics/profile_pics/basic.jpg" alt="IT'S ME" id="itsme">
        </div>
    </div><!--endof #honlapCelja-->


    <div id="kedvencek"></div><br>
    <div class="bg-info" >
        <h2>A kedvenc mezeim</h2>
                <div id="carouselIndex" class="carousel slide carousel-fade mt-1 indexCarausel" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselIndex" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselIndex" data-slide-to="1"></li>
                    <li data-target="#carouselIndex" data-slide-to="2"></li>
                    <li data-target="#carouselIndex" data-slide-to="3"></li>
                    <li data-target="#carouselIndex" data-slide-to="4"></li>
                </ol>

                <div class="carousel-inner text-center" role="listbox">
                    <div class="carousel-item active">
                        <p>Ez azért tetszik, mert...</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez1" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez meg azért tetszik, mert...</p>
                        <img src="public/resources/pics/carousel/2.jpg" alt="mez2" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez mert...</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez3" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez azért mert...</p>
                        <img src="public/resources/pics/carousel/2.jpg" alt="mez4" width="250px" >
                    </div>
                    <div class="carousel-item">
                        <p>Ez nem is tetszik.</p>
                        <img src="public/resources/pics/carousel/1.jpg" alt="mez5" width="250px" >
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselIndex" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#carouselIndex" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
        </div>
    </div><!--endof kedvencek-->


    <div id="linkek"></div><br>
    <div class="bg-grey "  >
        <H2>Linkek</H2>
        <h4 class="pb-3">Amennyiben érdekel Téged a téma, az alábbi linkeken találsz még mezeket. :)</h4>
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-4 pb-2" >
                    <div class="thumbnail bordered">
                        <a href="http://stevensfootballshirts.net/index2.html" target="_blank">
                            <img src="public/resources/pics/links/stevens.jpg" alt="stevensfootballshirts.net"/>
                        </a>
                        <p><strong>Steven futball mez gyűjteménye</strong></p>
                        <p>Szuper kis oldal, nekem nagyon tetszik</p>
                    </div>
                </div><!--endof LINK-->
                <div class="col-sm-4 pb-2">
                    <div class="thumbnail bordered">
                        <a href="https://www.kummerbube.com/" target="_blank">
                            <img src="public/resources/pics/links/kummerbube_banner.jpg" alt="kummerbube.com"/>
                        </a>
                        <p><strong>Egy magángyűjtemény, szuper!</strong></p>
                        <p>Azért tetszik, mert jól néz ki. </p>
                    </div>
                </div><!--endof LINK-->
                <div class="col-sm-4 pb-2">
                    <div class="thumbnail bordered">
                        <a href="http://fcbtrikots.ch/" target="_blank">
                            <img src="public/resources/pics/links/trikots.de.jpg" alt="fcbtrikots.ch"/>
                        </a>
                        <p><strong>Steven futballmez gyűjteménye</strong></p>
                        <p>Szuper kis oldal, nekem nagyon tetszik</p>
                    </div>
                </div><!--endof LINK-->
            </div><!--endof ROW-->
    </div><!--endof #linkek-->

     <div class="container-fluid height650 jumbotron" id="bg-picIndex2" >
    </div>

    <div id="kapcsolat"><br>
        <div class="jumbotron">
            <h2>Kapcsolat</h2>
            <h4 class="py-2">Amennyiben szeretnéd felvenni velem a kapcsolatot, üzenj nekem!</h4>
            <div class="">
                    <div class="row">
                        <!--myContact-->
                        <div class="col-xl-3 py-2">
                            <p>Add meg az adataidat, hogy tudjak válaszolni. </p>
                            <p><span class="fa fa-car fa-2x"></span>&nbsp&nbsp&nbsp Szeged, Magyarország</p>
                            <p><span class="fa fa-envelope fa-2x"></span>&nbsp&nbsp&nbsp myemail@something.com</p>
                        </div><!--endof myContact-->
                        <!--Message me-->
                        <div class="col-xl-9 py-2">
                            <form method="POST" action="#" id="emailForm">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6 form-group">
                                        <label for="email">Neved: </label>
                                        <input class="form-control" id="name" name="name" placeholder="Vezetéknév Keresztnév" type="text">
                                    </div>
                                    <div class="col-sm-6 col-lg-6 form-group">
                                        <label for="email">Email címed: </label>
                                        <input class="form-control" id="email" name="email" placeholder="example@example.com" type="email">
                                    </div>
                                    </div>
                                    <div class="row ">
                                    <div class="col-sm-12 form-group">
                                        <label for="email">Tárgy: </label>
                                        <input class="form-control" id="subject" name="subject" placeholder=" " type="text">
                                    </div>
                                </div>
                                    <label for="email">Üzenet: </label>
                                    <textarea class="form-control" id="content" name="content" placeholder="Üzenj nekem!" rows="5"></textarea>
                                <div class="row ">
                                    <div class="col form-group">
                                         <button class="btn btn-secondary pull-left" id="tartalomTorlese" type="button">Tartalom törlése</button>
                                    </div>
                                    <div class="col form-group ">
                                         <button class="btn btn-secondary pull-right" type="submit" name="submit">Üzenet küldése </button>
                                    </div>
                                </div>
                                <div class="error p-2 text-light"></div>
                                <div class="success p-2 text-light "></div>
                            </form><!--endof form-->
                        </div><!--endof messageMe-->
                    </div><!--endof row-->
            </div>
        </div><!--endof jumbotron -->
    </div><!--endof kapcsolat-->

<?php
//loginform appears, when click on icon in footer
if (isset($_POST['login-form']) && !empty($_POST['login-form'])) {
 echo file_get_contents('html/login-form.html');
} else {
 //no post for log in, shows nothing
}

; ?>
    <div class="jumbotron bg-grey"><!--loginForm-->
        <div class="row">
            <div class="col bg-construction height250 p-2">
                    <h2>Belépés</h2>
                    <h4>Csak jogosultsággal lehetséges. :(</h4>
            </div>
        </div>
        <div class="container">
            <form id="loginForm">
                <div class="p-2">
                    <label for="felhNev"><code>Felhasználónév: </code></label>
                    <input type="text" id="felhNev" name="felhNev" placeholder="-- Username --" class="form-control" required>
                </div>
                <div class="p-2">
                    <label for="jelszo"><code>Jelszó: </code></label>
                    <input type="password" id="jelszo" name="jelszo" placeholder="-- Password--" class="form-control" required>
                </div>
                <div class="row p-2">
                        <div class="col form-group ">
                            <button class="btn btn-secondary pull-left" type="button" name="reg">Regisztráció</button>
                        </div>
                        <div class="col form-group ">
                            <button class="btn btn-secondary pull-right" id="belepes" type="submit">Belépek</button>
                        </div>
                </div>
            </form>
        </div><!--endof container-->
    </div><!--endof Loginform-->
    </div> <!--endof Maindiv-->

