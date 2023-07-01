var express = require('express');
var app = express();
var ejs=require('ejs');
var mysql=require('mysql');
var bodyParser=require('body-parser');
var session=require('express-session');


var conn=mysql.createConnection({
    host:"localhost",
    user:"root",
    password:"",
    database:"node_commerce"

})
app.set('view engine','ejs');
app.use(bodyParser.urlencoded({extended:true}));
app.use(express.static('images'))
app.use(express.json());
app.use(session({
secret: 'secret-key',
resave: false,
saveUninitialized: false,
}));


app.get('/index', function (req, res) {
    conn.query("SELECT * FROM `inventory`",(err,result0)=>{
    var query="SELECT * FROM `users` WHERE `email`=?";
    var values=[[req.session.userid]];
    conn.query(query,[values],(err,result1)=>{
        res.render("index",{result1,result0});
    });
});
});

app.post('/addtocart', function (req, res) {
    

    var query="INSERT INTO `cart`(name,quantity,price,username) VALUES ?";
    var values=[[req.query.name,req.body.quantity,req.query.price,session.userid]];
    conn.query(query,[values],(err,result)=>{
    res.redirect("/index");
    });
});



app.get('/cart', function (req, res) {
    var query="SELECT * FROM `cart` WHERE `username`=?";
    conn.query(query,[session.userid],(err,result)=>{
        var grtotal=0;
        result.forEach(function(result)
        {
            grtotal+=Number(result.price*result.quantity);
        }); 
        res.render("cart",{result:result,total:grtotal});
 
});
});

app.get('/account', function (req, res) {
    

    var query="SELECT * FROM `users` WHERE `email`=?";
    conn.query(query,[session.userid],(err,result)=>{
        res.render("account",{result:result});
    })
})

app.post('/user_signup',(req,res)=>{
    var name=req.body.name;
    var email=req.body.email;
    var address=req.body.address;
    var phone=req.body.phone;
    var password=req.body.password;

    var query="INSERT INTO `users` (name,email,address,mobile,password) VALUES ?";
        var values=[[name,email,address,phone,password]];
        conn.query(query,[values],(err,result)=>{
        res.redirect('/signup');
    })
})

app.get('/',(req,res)=>{
    res.render("signin");
})

app.post('/user',(req,res) => {
    var query="SELECT * FROM users WHERE email=?";
    var mail=req.body.em;
    conn.query(query,[mail],(err,result)=>{
        
    if(req.body.em == result[0].email && req.body.ps == result[0].password){
        session=req.session;
        session.userid=req.body.em;
        console.log(session.userid);
        res.redirect('/index');
    }
    else{
        res.send('Invalid username or password');
    }

})
})

app.get('/signup',(req,res)=>{
    res.render("signup");
})

app.get('/logout',(req,res) => {
    req.session.destroy();
    res.redirect("/");
});

app.get('/summary',(req,res) => {
    res.render("summary");
});

app.post('/chngpass',(req,res) => {
    var query="UPDATE `users` SET `password`=? WHERE email=?";
    conn.query(query,[req.body.password,session.userid],(err,result)=>{
        res.redirect("/account");
    });
    
});

app.post('/delacc',(req,res) => {
    var query="DELETE FROM `users` WHERE email=?";
    conn.query(query,[session.userid],(err,result)=>{
        res.redirect("/");
    });
});

app.post('/removeitm',(req,res) => {
    var query="DELETE FROM `cart` WHERE name=? && username=?";
    conn.query(query,[req.body.remove,session.userid],(err,result)=>{
        res.redirect("/cart");
    });
});

app.listen (8081)