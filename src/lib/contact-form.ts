import Contact from '../struct/Contact.ts';
import type { ContactFormApiResponse } from '../types';

((): void => {
  const form: HTMLFormElement | null = <HTMLFormElement>document.getElementById('inquiryForm');
  if (!form) {
    console.error('Missing contact form element.');
    return;
  }
  const successAlert: HTMLElement = <HTMLElement>document!.getElementById('submit-success-alert');
  const errorAlert: HTMLElement = <HTMLElement>document!.getElementById('submit-error-alert');
  const loadingIndication: HTMLElement = <HTMLElement>document!.getElementById('loadingIndication');
  const specialRequest: HTMLFormElement = <HTMLFormElement>document.getElementById('specialRequest');

  const url: string = import.meta.env.PUBLIC_CONTACT_API_URL;

  function obSubmit(event: SubmitEvent): void {
    event.preventDefault();
    event.stopPropagation();

    hideAlerts();
    form?.classList.add('was-validated');

    if (form?.checkValidity() && !specialRequest.value) {
      const contact: Contact = Contact.fromFromData(new FormData(<HTMLFormElement>form));
      const formElements = <HTMLFormElement[]>Array.from(form?.elements || []);
      // Disable all form elements.
      formElements.forEach((formElement) => (formElement.disabled = true));
      loadingIndication.classList.remove('d-none');
      fetch(url, {
        method: 'POST',
        body: contact.toJson(),
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then((response: Response) => response.json())
        .then((data: ContactFormApiResponse) => {
          if (data?.success) {
            form?.classList.remove('was-validated');
            form?.reset();
            showSuccessAlert();
            return;
          }
          showErrorAlert();
          throw new Error('Contact request failed.');
        })
        .catch((error) => {
          showErrorAlert();
          console.error(error);
        })
        .finally(() => {
          loadingIndication.classList.add('d-none');
          // Enable all form elements.
          formElements.forEach((formElement) => (formElement.disabled = false));
        });
    }
  }

  function showErrorAlert(): void {
    errorAlert.classList.remove('d-none');
    successAlert.classList.add('d-none');
  }

  function showSuccessAlert(): void {
    successAlert.classList.remove('d-none');
    errorAlert.classList.add('d-none');
  }

  function hideAlerts() {
    errorAlert.classList.add('d-none');
    successAlert.classList.add('d-none');
  }

  form?.addEventListener('submit', obSubmit);
})();
