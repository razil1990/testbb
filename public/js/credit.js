  (function(){
    let creditSum = document.getElementById('creditSum');
    let creditSumRange = document.getElementById('creditSumRange');
    let creditTerm = document.getElementById('creditTerm');
    let creditTermRange = document.getElementById('creditTermRange');
    let creditDate = document.getElementById('creditDate');
    let creditRate = document.getElementById('creditRate');
    let paymentSchedule = document.getElementById('paymentSchedule');
    let payment = document.getElementById('payment');
    let rate = document.getElementById('rate');

    function init() {
      calculate(creditRate.value, creditSum.value, creditTerm.value);
      paymentSchedule.addEventListener('click', (evt) => {
        evt.preventDefault();
        if(document.getElementById('table')) {
          document.getElementById('table').remove();
        }
        makeSchedule(creditRate.value, creditSum.value, creditTerm.value);
      })

      let obj = {creditSum, creditSumRange, creditTerm, creditTermRange};
      for(let x in obj) {
        obj[x].addEventListener('input', (evt) => {
          evt.preventDefault();
          if(x.indexOf('Range') === -1) {
            range(obj[x+'Range'], obj[x]);
          } else {
            let a = x.split('Range', 2);
            range(obj[a[0]], obj[x]);
          }
          calculate(creditRate.value, creditSum.value, creditTerm.value);
        });
      }
    }

    function calculate(rate, sum, term) {
      let p = rate/100/12;
      let result = (sum * (p + (p/(((1+p)**term) - 1)))).toFixed(0)*1;
      if(isFinite(result)) {
        return payment.textContent = 'Ежемесячный платеж: ' + result + ' руб.';
      }
      return payment.textContent;  
    }

    function range(elem1, elem2) {
      elem1.value = elem2.value;
    }
    
    function makeSchedule(rate, sum, term) {
      let div = document.createElement('div');
      div.append(tmpl.content.cloneNode(true));
      let container = document.getElementById('container');
      container.append(div);
      let tbody = document.getElementById('tbody');
      let p = rate/100/12;
      let payment = (sum * (p + (p/(((1+p)**term) - 1)))).toFixed(0)*1;
      let date = new Date(creditDate.value);
      let percentage;
      let debt;
      while(sum > 0) {
        percentage = (sum*p).toFixed(0)*1;
        debt = (payment - percentage).toFixed(0)*1;
        if(payment > sum) {
          payment = sum;
          percentage = 0;
          debt = payment;
        }
        date = new Intl.DateTimeFormat().format(date).split('.').reverse().join('-');
        sum = sum - debt;
        let tr = document.createElement('tr'); 
        let arr = [date, payment, percentage, debt, sum];
        for(let i = 0; i < arr.length; i++) {
          let td = document.createElement('td');
          td.textContent = arr[i];
          tr.append(td);
        }
        tbody.append(tr);
        arr = null;
        date = new Date(Date.parse(date));
        date.setMonth(date.getMonth() + 1);
      }
      div.scrollIntoView();
    }
    init();
})();