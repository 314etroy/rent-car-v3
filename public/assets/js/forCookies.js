window.addEventListener("load", function () {
    window.wpcc.init({
        border: "thin",
        corners: "small",
        colors: {
            popup: {
                background: "#FFFFFF",
                text: "#222",
                border: "none",
            },
            button: {
                background: "#070415",
                text: "#FFFFFF",
            },
        },
        position: "bottom-left",
        content: {
            href: "https://starentinchirieriauto.ro/politica-de-cookie",
            message:
                "Folosim cookie-uri și alte tehnologii de urmărire pentru a îmbunătăți experiența ta de navigare pe website-ul nostru, pentru a analiza traficul de pe website-ul nostru și pentru a înțelege de unde vin vizitatorii noștri.",
            link: "Politica de Cookie",
            button: "Sunt de acord!",
        },
    });
});
