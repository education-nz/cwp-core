import Injector from 'lib/Injector';

Injector.transform(
  'require-alt-text',
  (updater) => {
    updater.form.addValidation(
      'AssetAdmin.*',
      (values, Validation) => {
        if (typeof values.AltText === 'undefined') {
          return;
        }

        const alt = (!values.AltText || values.AltText.length < 1) ? 'Alt text is required' : null

        if (alt) {
          Validation.addError('AltText', alt);
        }
      }
    );
  }
);
