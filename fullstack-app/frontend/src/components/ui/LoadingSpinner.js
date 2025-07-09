import React from 'react';

const LoadingSpinner = ({ size = 'md', className = '' }) => {
  const sizeClasses = {
    sm: 'w-4 h-4',
    md: 'w-6 h-6',
    lg: 'w-8 h-8',
    xl: 'w-12 h-12'
  };

  const spinnerStyle = {
    width: size === 'sm' ? '16px' : size === 'md' ? '24px' : size === 'lg' ? '32px' : '48px',
    height: size === 'sm' ? '16px' : size === 'md' ? '24px' : size === 'lg' ? '32px' : '48px'
  };

  return (
    <div className={`spinner ${className}`} style={spinnerStyle} />
  );
};

export default LoadingSpinner;