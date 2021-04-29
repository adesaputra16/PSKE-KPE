const jadwal = () => {
  const d = new Date();
  const url = `https://api.banghasan.com/sholat/format/json/jadwal/kota/588/tanggal/${d.getFullYear()}-${satuNolDiDepan(d.getMonth() + 1)}-${satuNolDiDepan(d.getDate())}`;

  fetch(url)
    .then((resp) => resp.json())
    .then(function (data) {
      let authors = data;
      // console.log(authors);
      if (authors.status === "ok") {
        const object = authors.jadwal.data;
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 10000,
        });

        setInterval(() => {
          const date = new Date();
          let time = `${satuNolDiDepan(date.getHours())}:${satuNolDiDepan(date.getMinutes())}`;
          for (let property in object) {
            if (object[property] == time) {
              return Toast.fire({
                icon: "info",
                title: `<h5> Sudah jam ${time} waktunya sholat.</h5>`,
              });
            }
          }
        }, 50000);
      }
    })
    .catch(function (error) {
      console.log(error);
    });
};

const toastNotifikasi = (icon, title) => {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
  });

  return Toast.fire({
    icon: icon,
    title: title,
  });
};

const alertBox = (icon, title, text) => {
  return Swal.fire({
    timer: 1500,
    timerProgressBar: true,
    title: title,
    text: text,
    icon: icon,
  });
};

// const formatNumber = (num) => num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

const formatNumber = (num) => {
  num += "";
  x = num.split(".");
  x1 = x[0];
  x2 = x.length > 1 ? "," + x[1] : "";
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, "$1" + "." + "$2");
  }
  return x1 + x2;
};

const satuNolDiDepan = (x) => (y = x > 9 ? x : "0" + x);

const duaNolDiDepan = (x) => (y = x > 9 ? "0." + x : "0.0" + x);

const preLoader = () => {
  $("#loader").fadeIn();
  $("div#divTable").removeAttr("style");
  loader();
};

$(function () {
  $("input#DATA_eDATE").attr("readonly", "readonly");
  $("input#DATA_sDATE")
    .datepicker()
    .on("changeDate", function (ev) {
      let TANGGAL_AWAL = $("input#DATA_sDATE").val();
      // alert(TANGGAL_AWAL);
      //MENENTUKAN TANGGAL AKHIRNYA SEMINGGU DARI TANGGAL AWAL
      let myDate = new Date(TANGGAL_AWAL);
      myDate.setDate(myDate.getDate() + 6);

      let month = "" + (myDate.getMonth() + 1),
        day = "" + myDate.getDate(),
        year = myDate.getFullYear();
      if (month.length < 2) month = "0" + month;
      if (day.length < 2) day = "0" + day;
      let TANGGAL_AKHIR = year + "/" + month + "/" + day;
      //END MENETUKAN TANGGAL AKHIRNYA
      // alert(TANGGAL_AKHIR);
      let JENIS_LAPORAN = $("select#JENIS_LAPORAN").val();
      if (JENIS_LAPORAN == "Harian") {
        $("input#DATA_eDATE").val("");
      } else {
        $("input#DATA_eDATE").val(TANGGAL_AKHIR);
      }
      $(".datepicker").datepicker("hide");
    });
});

function formatDate(date) {
  // console.log(date);
  let d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

function codding(x) {
  if (x < 10) {
    y = "00" + x;
  } else if (x < 100) {
    y = "0" + x;
  } else {
    y = x;
  }
  return y;
}
