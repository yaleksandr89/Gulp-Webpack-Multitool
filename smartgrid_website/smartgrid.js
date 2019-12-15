/* global module*/
module.exports = {
    filename: '_smart-grid',
    outputStyle: 'scss', // less|sass|scss|stylus
    columns: 12, /* number of grid columns */
    offset: '30px', /* gutter width px || % || rem */
    container: {
        maxWidth: '1140px', /* max-width оn the very large screen */
        fields: '30px' /* side fields */
    },
    breakPoints: {
        lg: {
            width: '992px',
            fields: '15px'
        },
        md: {
            width: '768px'
        },
        sm: {
            width: '500px',
        },
        xs: {
            width: '320px',
        }
    }
};