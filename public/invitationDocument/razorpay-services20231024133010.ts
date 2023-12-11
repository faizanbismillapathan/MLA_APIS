import { Injectable } from "@angular/core";
import { ICustomWindow, WindowRefService } from 'src/app/window-ref.service';
import Swal from 'sweetalert';

@Injectable({
  providedIn: "root",
})
export class RazorpayService {

  private _window: ICustomWindow;
  public rzp: any;

  constructor(private winRef: WindowRefService) { }

  razorpay() {
    return new Promise(resolve => {

      const options: any = {
        // key: 'rzp_test_tW2ooYee82PUzk',
        // key_secret: 'pIt2BMh0XL74y5z1E4nRcbAG',
        key: 'rzp_live_Fl8NriS2lGq531',
        key_secret: 'hLdT7Fow2oLa4lFWYIkfBkC0',
        amount: 100, // amount should be in paise format to display Rs 1255 without decimal point
        currency: 'INR',
        name: 'The Bizz', // company name or product name
        description: 'The Bizz',  // product description
        image: 'https://thebizz.in/theBizz-logo.png', // company logo or product image
        // order_id: '1234567890', // order_id created by you in backend
        modal: {
          // We should prevent closing of the form when esc key is pressed.
          escape: false,
        },
        notes: {
          // include notes if any
        },
        theme: {
          color: '#001f3f'
        }
      };
      options.handler = ((response, error) => {
        options.response = response;
        resolve(response);
        console.log(response);
        console.log(options);
        // call your backend api to verify payment signature & capture transaction
      });
      options.modal.ondismiss = (() => {
        // handle the case when user closes the form while transaction is in progress
        console.log('Transaction cancelled.');
        resolve({message: 'Transaction cancelled.'});
      });

      Swal.fire({
        title: 'Do you wanna pay now?',
        text: 'You need to pay the amount before activate the card!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'No, cancel it'
      }).then((result) => {
        if (result.value) {
          this.rzp = new this.winRef.nativeWindow['Razorpay'](options);
          this.rzp.open();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'You have cancelled the payment.',
          'error'
        )
        }
      })


      
      
    })
  }

}