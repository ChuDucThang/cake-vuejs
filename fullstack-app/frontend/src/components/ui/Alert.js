import React from 'react';

const Alert = ({ type = 'success', message, onClose, className = '' }) => {
  if (!message) return null;

  const alertClasses = {
    success: 'alert-success',
    error: 'alert-error',
    warning: 'alert-warning',
  };

  return (
    <div className={`alert ${alertClasses[type]} ${className}`}>
      <div className="flex justify-between align-center">
        <span>{message}</span>
        {onClose && (
          <button
            onClick={onClose}
            className="btn btn-secondary btn-sm"
            style={{ marginLeft: '1rem', padding: '0.25rem 0.5rem' }}
          >
            ×
          </button>
        )}
      </div>
    </div>
  );
};

export default Alert;