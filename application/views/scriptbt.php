<script>
    var minstake = 0.00000001;  // valor base
    var autorounds = 123;         // n° de rolls
    var handbrake = 0.0001;  // valor lose pause game
    var autoruns = 1;
    function playnow() {
        if (autoruns > autorounds) {
            console.log('Limit reached');
            return;
        }
        document.getElementById('double_your_btc_bet_hi_button').click();
        setTimeout(checkresults, 123);
        return;
    }
    function checkresults() {
        if (document.getElementById('double_your_btc_bet_hi_button').disabled === true) {
            setTimeout(checkresults, 246);
            return;
        }
        var stake = document.getElementById('double_your_btc_stake').value * 1;
        var won = document.getElementById('double_your_btc_bet_win').innerHTML;
        if (won.match(/(\d+\.\d+)/) !== null) {
            won = won.match(/(\d+\.\d+)/)[0];
        } else {
            won = false;
        }
        var lost = document.getElementById('double_your_btc_bet_lose').innerHTML;
        if (lost.match(/(\d+\.\d+)/) !== null) {
            lost = lost.match(/(\d+\.\d+)/)[0];
        } else {
            lost = false;
        }
        if (won && !lost) {
            stake = minstake;
            console.log('Bet #' + autoruns + '/' + autorounds + ': Won  ' + won + ' Stake: ' + stake.toFixed(8));
        }
        if (lost && !won) {
            stake = lost * 2.1;
            console.log('Bet #' + autoruns + '/' + autorounds + ': Lost ' + lost + ' Stake: ' + stake.toFixed(8));
        }
        if (!won && !lost) {
            console.log('Something went wrong');
            return;
        }
        document.getElementById('double_your_btc_stake').value = stake.toFixed(8);
        autoruns++;
        if (stake >= handbrake) {
            document.getElementById('handbrakealert').play();
            console.log('Handbrake triggered! Execute playnow() to override');
            return;
        }
        setTimeout(playnow, 111);
        return;

    }
    playnow()
</script>