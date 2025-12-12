{\rtf1\ansi\ansicpg1252\cocoartf2822
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 // Booking form\
document.getElementById("bookForm").addEventListener("submit", function(e)\{\
  e.preventDefault();\
  alert("Booking submitted successfully!");\
\});\
\
// Enquiry form\
document.getElementById("enquiryForm").addEventListener("submit", function(e)\{\
  e.preventDefault();\
\
  const name = e.target[0].value;\
  const email = e.target[1].value;\
  const message = e.target[2].value;\
\
  const enquiry = \{ name, email, message \};\
\
  let list = JSON.parse(localStorage.getItem("dwiseEnquiries") || "[]");\
  list.push(enquiry);\
  localStorage.setItem("dwiseEnquiries", JSON.stringify(list));\
\
  alert("Enquiry sent!");\
\
  e.target.reset();\
  loadAdmin();\
\});\
\
// Admin dashboard\
function loadAdmin()\{\
  const ul = document.getElementById("adminList");\
  ul.innerHTML = "";\
\
  const list = JSON.parse(localStorage.getItem("dwiseEnquiries") || "[]");\
\
  list.forEach(e => \{\
    const li = document.createElement("li");\
    li.innerHTML = `<strong>$\{e.name\}</strong> - $\{e.email\}<br>$\{e.message\}<br><hr>`;\
    ul.appendChild(li);\
  \});\
\}\
\
loadAdmin();}
