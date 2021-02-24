(function(){
  let depositSum = document.getElementById('depositSum');
  let depositSumRange = document.getElementById('depositSumRange');
  let depositTerm = document.getElementById('depositTerm');
  let depositTermRange = document.getElementById('depositTermRange');
  let depositDate = document.getElementById('depositDate');
  let depositClose = document.getElementById('depositClose');
  let depositRate = document.getElementById('depositRate');
  let depositRateShow = document.getElementById('depositRateShow');
  let capitalizationShow = document.getElementById('capitalizationShow');
  
  function range(elem1, elem2) {
    elem1.value = elem2.value;
  }
  
  function calculate() {
    let dateOpen = new Date(depositDate.value);
    let dateClose = new Date(depositDate.value);
    dateClose.setMonth(dateClose.getMonth() + depositTerm.value*1);
    let t = (dateClose.getTime() - dateOpen.getTime());
    t = t/1000/3600/24;
    let capitalization = Math.round(depositSum.value * depositRate.value/100 * (t/365)); 
    depositRateShow.textContent = 'Ставка: ' + depositRate.value + '%';
    let total_sum = depositSum.value*1 + capitalization;
    capitalizationShow.textContent = 'Полная выплата по вкладу: ' + total_sum + ' руб.';
  }
  calculate();

  let obj = {depositSum, depositSumRange, depositTerm, depositTermRange};
    for(let x in obj) {
      obj[x].addEventListener('input', (evt) => {
        evt.preventDefault();
        if(x.indexOf('Range') === -1) {
          range(obj[x+'Range'], obj[x]);
        } else {
          let a = x.split('Range', 2);
          range(obj[a[0]], obj[x]);
        }
        calculate();
      });
    }
})(); 
