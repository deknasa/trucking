var terbilang = function (number) {
      
  // Array kosong untuk menampung kata terbilang
  
  let words = [];
  
  // Array untuk menampung angka terbilang
  const units = [
  "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
  ];
  
  // Konversi angka menjadi terbilang
  if (number < 12) {
    words.push(units[number]);
  } else if (number < 20) {
    words.push(terbilang(number - 10) + " Belas");
  } else if (number < 100) {
    words.push(terbilang(Math.floor(number / 10)) + " Puluh");
    if (number % 10 !== 0) {
      words.push(terbilang(number % 10));
    }
  } else if (number < 200) {
    words.push("Seratus", terbilang(number - 100));
  } else if (number < 1000) {
    words.push(terbilang(Math.floor(number / 100)) + " Ratus");
    if (number % 100 !== 0) {
      words.push(terbilang(number % 100));
    }
  } else if (number < 2000) {
    words.push("Seribu", terbilang(number - 1000));
  } else if (number < 1000000) {
    words.push(terbilang(Math.floor(number / 1000)) + " Ribu");
    if (number % 1000 !== 0) {
      words.push(terbilang(number % 1000));
    }
  } else if (number < 1000000000) {
    words.push(terbilang(Math.floor(number / 1000000)) + " Juta");
    if (number % 1000000 !== 0) {
      words.push(terbilang(number % 1000000));
    }
  } else if (number < 1000000000000) {
    words.push(terbilang(Math.floor(number / 1000000000)) + " Miliar");
    if (number % 1000000000 !== 0) {
      words.push(terbilang(number % 1000000000));
    }
  } else {
    words.push("Angka terlalu besar");
  }
  // Menggabungkan semua kata terbilang menjadi satu string
  return words.join(" ");
};
  