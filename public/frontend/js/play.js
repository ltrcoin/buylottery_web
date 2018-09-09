function range (start, end) {
  var ans = []
  for (let i = start; i <= end; i++) {
    ans.push(i)
  }
  return ans
}

function array_tickets (lines) {
  var tickets = []
  for (let i = 0; i < lines.length; i++) {
    tickets.push([])
  }
  return tickets
}

/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt (min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min
}

/**
 *
 * @param arr: input array
 * @param num: number of random numbers
 * @param set: result set
 */
function quickDraw (arr, num, set) {
  set = set || []
  if (num === set.length) {
    set.sort(function (a, b) {
      return a - b
    })
    return set
  }
  var randomIndex = getRandomInt(0, arr.length - 1)
  set.push(arr[randomIndex])
  arr.splice(randomIndex, 1)
  return quickDraw(arr, num, set)
}

$(function () {
  var gameInfo = JSON.parse($('input[name=game_info]').val())
  var lines = [1, 2, 3]
  var ractive = new Ractive({
    target: 'ticket-pick-area',
    template: `
    <div class="pick-area row">
      <div class="col-md-12 select-lines">
          <div class="col-xs-4 col-md-2">
            <span on-click="@this.changeLines(3)">3 Lines</span>
          </div><div class="col-xs-4 col-md-2">
            <span on-click="@this.changeLines(5)">5 Lines</span>
          </div><div class="col-xs-4 col-md-2">
            <span on-click="@this.changeLines(10)">10 Lines</span>
          </div><div class="col-xs-4 col-md-2">
             <span on-click="@this.changeLines(15)">15 Lines</span>
          </div><div class="col-xs-4 col-md-2">
            <span on-click="@this.changeLines(20)">20 Lines</span>
          </div><div class="col-xs-4 col-md-2">
            <span on-click="@this.changeLines(25)">25 Lines</span>
          </div>
      </div>
      {{#each lines: index}}
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 one-ticket" data-line-index="{{ index }}">
      <div class="ticket-pick">
          <div class="numbers-to-pick">Choose {{ numbers }}</div>
          <i class="fa fa-check"></i>
          <div class="normal-num">
            {{#each normal_range: i}}
            <div class="a-number">{{ normal_range[i] }}</div>
            {{/each}}     
          </div>
          {{#if has_special }}    
          <div class="numbers-to-pick">Choose 1</div>
          <div class="special-num">
              {{#each special_range: i}}
              <div class="a-special-num">{{ special_range[i] }}</div>
              {{/each}}
          </div>
          {{/if}}       
      </div>
      </div>
      {{/each}}
      {{#each lines: i}}
      <input type="hidden" name="normal[{{i}}]" value="{{ tickets[i].normal.join(' ') }}">
      <input type="hidden" name="special[{{i}}]" value="{{ tickets[i].special.join(' ') }}">
      {{/each}}
    </div>
    <div class="price-area col-md-12">
        <p class="ticket-price">Ticket Price ({{ lines.length }} x {{ ticket_price }} LTR): <span class="total-ticket-price">{{ lines.length * ticket_price }}</span> LTR</p>
        <button class="btn btn-submit-ticket">Play</button>
    </div>
    `,
    data: {
      numbers: gameInfo.numbers,
      has_special: gameInfo.has_special_number,
      special_numbers: gameInfo.special_numbers,
      normal_range: range(gameInfo.min_number, gameInfo.max_number),
      special_range: range(gameInfo.min_special, gameInfo.max_special),
      ticket_price: gameInfo.ticket_price,
      num_of_lines: 3,
      lines: lines,
      tickets: array_tickets(lines)
    },
    changeLines: function (number) {
      var lines = range(1, number)
      ractive.set({
        lines: lines
      })
      var tickets = ractive.get('tickets')
      if (tickets.length < number) {
        for (let i = tickets.length; i < number; i++) {
          tickets[i] = []
        }
      } else {
        tickets.splice(number, tickets.length - number)
      }
      ractive.set({
        tickets: tickets
      })
    }
  })

  $(document).on('click', '.a-number', function () {
    var lineIndex = $(this).closest('.one-ticket').data('line-index')
    var tickets = ractive.get('tickets')
    if ($(this).hasClass('picked')) {
      $(this).removeClass('picked')
      $(this).closest('.ticket-pick').removeClass('valid-ticket')
      tickets[lineIndex].normal = []
    } else {
      if ($(this).closest('.normal-num').find('.picked').length < gameInfo.numbers) {
        $(this).addClass('picked')
        var pickedNormals = []
        $(this).closest('.normal-num').find('.picked').each(function () {
          pickedNormals.push(+$(this).html())
        })

        if (pickedNormals.length === gameInfo.numbers) {
          tickets[lineIndex].normal = pickedNormals
          if (
            ($('input[name="special[' + lineIndex + ']"]').val() !== '') ||
            !ractive.get('has_special')
          ) {
            $(this).closest('.ticket-pick').addClass('valid-ticket')
          }
        }
      }
    }
    ractive.set({
      tickets: tickets
    })
  })
  $(document).on('click', '.a-special-num', function () {
    var lineIndex = $(this).closest('.one-ticket').data('line-index')
    var tickets = ractive.get('tickets')

    if ($(this).hasClass('picked')) {
      $(this).removeClass('picked')
      tickets[lineIndex].special = null
      $(this).closest('.ticket-pick').removeClass('valid-ticket')
    } else {
      console.log($(this).closest('.special-num').find('.picked').length)
      console.log(gameInfo.special_numbers)
      if ($(this).closest('.special-num').find('.picked').length < gameInfo.special_numbers) {
        console.log('a')
        var pickedSpecial = []
        $(this).addClass('picked')
        $(this).closest('.special-num').find('.picked').each(function () {
          pickedSpecial.push(+$(this).html())
        })
        console.log(pickedSpecial)
        console.log(gameInfo.special_numbers)
        if (pickedSpecial.length === gameInfo.special_numbers) {
          tickets[lineIndex].special = pickedSpecial
          if (ractive.get('tickets')[lineIndex].hasOwnProperty('normal')) {
            $(this).closest('.ticket-pick').addClass('valid-ticket')
          } else {
            $(this).closest('.ticket-pick').removeClass('valid-ticket')
          }
        }
      }
    }
    ractive.set({
      tickets: tickets
    })
  })

  $(document).on('click', '.btn-submit-ticket', function (e) {
    e.preventDefault()
    // only submit tickets when all tickets are valid
    if ($('.valid-ticket').length === ractive.get('tickets').length) {
      $(this).closest('form').submit()
    }
  })

  $(document).on('change', 'input[name=number_of_lines]', function () {
    var numOfLines = +$(this).val()
    var lines = range(1, numOfLines)
    ractive.set({
      lines: lines
    })
    var tickets = ractive.get('tickets')
    if (tickets.length < numOfLines) {
      for (let i = tickets.length; i < numOfLines; i++) {
        tickets[i] = []
      }
    } else {
      tickets.splice(numOfLines, tickets.length - numOfLines)
    }
    ractive.set({
      tickets: tickets
    })
  })
})